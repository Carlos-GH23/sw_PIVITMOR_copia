<?php

namespace App\Http\Controllers\Admin\Users;

use App\Exports\AcademicUsersExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\Institution\AcademicResource;
use Illuminate\Http\Request;
use App\Models\Academic;
use App\Models\Capability;
use App\Models\Requirement;
use App\Models\TechnologyService;
use App\Traits\Filterable;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use App\Traits\HasOrderableRelations;

class AcademicUsersController extends Controller
{
    use Filterable;
    use HasOrderableRelations;
    protected string $routeName;
    protected string $source;

    public function __construct()
    {
        $this->routeName = "users.academicProfile.";
        $this->source    = "Core/Admin/Users/Academics/Pages/";

        $this->middleware("permission:users.academicProfile")->only(['index', 'show']);
    }

    public function index(Request $request)
    {
        $filters = $this->getFiltersBase($request->query());
        $academics = $this->getPaginatedAcademics($filters);

        return Inertia::render("{$this->source}Index", [
            'title'     => 'Gestión de Académicos',
            'academics' => AcademicResource::collection($academics),
            'routeName' => $this->routeName,
            'filters'   => $filters
        ]);
    }

    private function getPaginatedAcademics($filters)
    {
        $query = Academic::query()
            ->with(['department.institution', 'user', 'photo'])
            ->whereHas('user', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->when($filters->search, function ($query, $search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('first_name', 'LIKE', "%{$search}%")
                        ->orWhere('last_name', 'LIKE', "%{$search}%")
                        ->orWhere('second_last_name', 'LIKE', "%{$search}%")
                        ->orWhereRelation('department', 'name', 'LIKE', "%{$search}%")
                        ->orWhereRelation('department.institution', 'name', 'LIKE', "%{$search}%");
                });
            })
            ->when($filters->withTrashed, function ($query) {
                $query->withTrashed();
            });

        if ($filters->order === 'name') {
            $query->orderBy('first_name', $filters->direction)->orderBy('last_name', $filters->direction);
        } elseif ($filters->order === 'department.name') {
            $query->leftJoin('departments', 'departments.id', '=', 'academics.department_id');
            $query->select('academics.*');
            $query->orderBy('departments.name', $filters->direction);
        } elseif ($filters->order === 'department.institution.name') {
            $query->leftJoin('departments', 'departments.id', '=', 'academics.department_id');
            $query->leftJoin('institutions', 'institutions.id', '=', 'departments.institution_id');
            $query->select('academics.*');
            $query->orderBy('institutions.name', $filters->direction);
        }

        $academics = $query->paginate($filters->rows)->withQueryString();

        $userIds = $academics->getCollection()->pluck('user_id')->filter()->unique()->toArray();
        $servicesCounts = TechnologyService::whereIn('user_id', $userIds)
            ->where('is_active', true)
            ->groupBy('user_id')
            ->selectRaw('user_id, COUNT(*) as count')
            ->pluck('count', 'user_id');

        $academics->getCollection()->transform(function ($academic) use ($servicesCounts) {
            $academic->active_technology_services_count = $servicesCounts[$academic->user_id] ?? 0;
            return $academic;
        });

        if ($filters->order === 'active_technology_services_count') {
            $sorted = $academics->getCollection()->sortBy('active_technology_services_count', SORT_REGULAR, $filters->direction === 'desc');
            $academics->setCollection($sorted->values());
        }

        return $academics;
    }

    public function enable(Academic $academic)
    {
        try {
            if (!$academic->user || $academic->user->trashed()) {
                return redirect()
                    ->route("{$this->routeName}index")
                    ->with('error', 'No se puede cambiar el estado: el usuario asociado ha sido eliminado');
            }

            $currentStatus = (bool) $academic->is_active;
            $newStatus     = $currentStatus ? 0 : 1;

            DB::beginTransaction();

            $academic->update(['is_active' => $newStatus]);
            $academic->user->update(['is_active' => $newStatus]);

            $conferenceStatusId = 3;
            $conferenceIds = $academic->conferences()->pluck('conference_id');
            if ($conferenceIds->count() > 0) {
                DB::table('conferences')
                    ->whereIn('id', $conferenceIds)
                    ->update(['conference_status_id' => $conferenceStatusId]);
            }

            if ($academic->user_id) {
                TechnologyService::where('user_id', $academic->user_id)->update(['is_active' => $newStatus]);
                Capability::where('user_id', $academic->user_id)->update(['is_active' => $newStatus]);
                Requirement::where('user_id', $academic->user_id)->update(['is_active' => $newStatus]);
                $conferenceStatusId = 3;
                $conferenceIds = DB::table('conference_academics')->where('academic_id', $academic->id)->pluck('conference_id');
                if ($conferenceIds->count() > 0) {
                    DB::table('conferences')
                        ->whereIn('id', $conferenceIds)
                        ->update(['conference_status_id' => $conferenceStatusId]);
                }
            }

            DB::commit();

            return redirect()
                ->route("{$this->routeName}index")
                ->with('success', 'Estado del académico actualizado con éxito');
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage(), [$exception]);

            return redirect()
                ->route("{$this->routeName}index")
                ->with('error', 'Ha ocurrido un error al intentar actualizar el estado');
        }
    }

    protected function getOrderableRelations(): array
    {
        return [
            'department.name',
            'department.institution.name',
        ];
    }

    public function exportPdf()
    {
        $this->authorize('users.exportFiles');
        $academics = Academic::with(['user', 'department'])->get();
        $pdf = Pdf::loadView('Users.AcademicUsersPDF', compact('academics'));
        $date = now()->format('Y-m-d');
        return $pdf->download("usuarios_academico_{$date}.pdf");
    }

    public function exportExcel()
    {
        $this->authorize('users.exportFiles');
        return Excel::download(new AcademicUsersExport, "academicos_".now()->format('Y-m-d').".xlsx");
    }
}
