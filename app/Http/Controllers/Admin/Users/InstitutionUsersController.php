<?php

namespace App\Http\Controllers\Admin\Users;

use App\Exports\InstitutionUsersExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Institution\Institution;
use App\Http\Resources\Institution\InstitutionResource;
use App\Models\Academic;
use App\Models\Capability;
use App\Models\Conference;
use App\Models\Institution\Facility;
use App\Models\Institution\FacilityEquipment;
use App\Models\Institution\InstitutionCertification;
use App\Models\Requirement;
use App\Models\TechnologyService;
use App\Models\User;
use App\Traits\Filterable;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Traits\HasOrderableRelations;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class InstitutionUsersController extends Controller
{
    use Filterable;
    use HasOrderableRelations;

    protected string $routeName;
    protected string $source;


    public function __construct()
    {
        $this->routeName = "users.institutionProfile.";
        $this->source    = "Core/Admin/Users/Institutions/Pages/";

        $this->middleware("permission:users.institutionProfile")->only(['index', 'show']);
    }

    public function index(Request $request)
    {
        $filters = $this->getFiltersBase($request->query());
        $query = Institution::query()
            ->with(['institutionType.institutionCategory', 'departments', 'logo', 'user'])
            ->whereHas('user', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->when($filters->search, function ($query, $search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('institutions.name', 'LIKE', '%' . $search . '%')
                        ->orWhere('institutions.description', 'LIKE', '%' . $search . '%')
                        ->orWhereRelation('institutionType', 'name', 'LIKE', '%' . $search . '%')
                        ->orWhereRelation('institutionType.institutionCategory', 'name', 'LIKE', '%' . $search . '%');
                });
            })
            ->when($filters->withTrashed, function ($query) {
                $query->withTrashed();
            });

        if ($filters->order === 'institution_categories.name') {
            $query->leftJoin('institution_types', 'institution_types.id', '=', 'institutions.institution_type_id');
            $query->leftJoin('institution_categories', 'institution_categories.id', '=', 'institution_types.institution_category_id');
            $query->select('institutions.*');
            $query->orderBy('institution_categories.name', $filters->direction);
        } else {
            $this->applyOrdering($query, $filters->order, $filters->direction);
        }
        $institutions = $query->paginate($filters->rows)->withQueryString();

        return Inertia::render("{$this->source}Index", [
            'title'     => 'Gestión de Instituciones',
            'institutions' => InstitutionResource::collection($institutions),
            'routeName' => $this->routeName,
            'filters'   => $filters
        ]);
    }

    public function enable(Institution $institution)
    {
        try {
            if ($institution->user()->exists() && $institution->user->trashed()) {
                return redirect()
                    ->route("{$this->routeName}index")
                    ->with('error', 'No se puede cambiar el estado: el usuario asociado ha sido eliminado');
            }

            $currentStatus = (bool) $institution->is_active;
            // Si se desactiva, status = 3; si se habilita, status = 1 (borrador)
            $newStatus     = $currentStatus ? 0 : 1;
            $newInstitutionStatus = $newStatus ? 1 : 3;

            DB::beginTransaction();

            $institution->update([
                'is_active' => $newStatus,
                'conference_status_id' => $newInstitutionStatus
            ]);

            $departmentIds = $institution->departments()->pluck('id');

            if ($institution->user()->exists()) {
                $institution->user()->update(['is_active' => $newStatus]);
            }

            if ($departmentIds->isEmpty()) {
                DB::commit();
                return redirect()
                    ->route("{$this->routeName}index")
                    ->with('success', 'Estado de la institución actualizado con éxito');
            }

            $institution->departments()->update(['is_active' => $newStatus]);
            FacilityEquipment::whereIn('department_id', $departmentIds)->update(['status' => $newStatus]);
            Facility::whereIn('department_id', $departmentIds)->update(['is_active' => $newStatus]);
            Academic::whereIn('department_id', $departmentIds)->update(['is_active' => $newStatus]);

            $userIds = Academic::whereIn('department_id', $departmentIds)
                ->whereNotNull('user_id')
                ->pluck('user_id');
            User::whereIn('id', $userIds)->update(['is_active' => $newStatus]);

            InstitutionCertification::whereIn('department_id', $departmentIds)->update(['is_active' => $newStatus]);
            TechnologyService::whereIn('department_id', $departmentIds)->update(['is_active' => $newStatus]);
            Requirement::whereIn('department_id', $departmentIds)->update(['is_active' => $newStatus]);
            Capability::whereIn('department_id', $departmentIds)->update(['is_active' => $newStatus]);
            Conference::whereIn('department_id', $departmentIds)->update(['conference_status_id' => $newInstitutionStatus]);

            DB::commit();

            return redirect()
                ->route("{$this->routeName}index")
                ->with('success', 'Estado de la institución actualizado con éxito');
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
            'institution_types.name' => ['institution_types', 'institution_type_id', 'name'],
            'institution_categories.name' => ['institution_categories', 'institution_category_id', 'name'],
        ];
    }

    public function exportPdf()
    {
        $this->authorize('users.exportFiles');

        $institutions = Institution::with(['institutionType.institutionCategory'])->get();
        $pdf = Pdf::loadView('Users.InstitutionUsersPDF', compact('institutions'));
        $date = now()->format('Y-m-d');
        return $pdf->download("usuarios_institucion_{$date}.pdf");
    }

    public function exportExcel()
    {
        $this->authorize('users.exportFiles');
        
        return Excel::download(new InstitutionUsersExport, "instituciones_".now()->format('Y-m-d').".xlsx");
    }
}
