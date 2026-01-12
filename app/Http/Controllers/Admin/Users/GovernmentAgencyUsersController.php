<?php

namespace App\Http\Controllers\Admin\Users;

use App\Exports\GovernmentAgencyUsersExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GovernmentAgency\GovernmentAgency;
use App\Http\Resources\GovernmentAgency\GovernmentAgencyResource;
use App\Traits\Filterable;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class GovernmentAgencyUsersController extends Controller
{
    use Filterable;
    protected string $routeName;
    protected string $source;

    public function __construct()
    {
        $this->routeName = "users.governmentAgencyProfile.";
        $this->source    = "Core/Admin/Users/GovernmentAgencies/Pages/";

        $this->middleware("permission:users.governmentAgencyProfile")->only(['index', 'show']);
    }

    public function index(Request $request)
    {
        $filters = $this->getFiltersBase($request->query());
        $query = GovernmentAgency::with(['logo', 'location', 'contact', 'user', 'governmentLevel', 'governmentSector'])
            ->whereHas('user', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->when($filters->search, function ($query, $search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('acronym', 'LIKE', "%{$search}%")
                        ->orWhere('objectives', 'LIKE', "%{$search}%")
                        ->orWhereHas('governmentSector', function ($query) use ($search) {
                            $query->where('name', 'LIKE', "%{$search}%");
                        })
                        ->orWhereHas('governmentLevel', function ($query) use ($search) {
                            $query->where('name', 'LIKE', "%{$search}%");
                        });
                });
            })
            ->when($filters->withTrashed, function ($query) {
                $query->withTrashed();
            });

        $agencies = $query->orderBy($filters->order, $filters->direction)
            ->paginate($filters->rows)
            ->withQueryString();

        return Inertia::render("{$this->source}Index", [
            'title'     => 'Gestión de Dependencias de Gobierno',
            'agencies'  => GovernmentAgencyResource::collection($agencies),
            'routeName' => $this->routeName,
            'filters'   => $filters
        ]);
    }

    public function enable(GovernmentAgency $governmentAgency)
    {
        try {
            if (!$governmentAgency->user || $governmentAgency->user->trashed()) {
                return redirect()
                    ->route("{$this->routeName}index")
                    ->with('error', 'No se puede cambiar el estado: el usuario asociado ha sido eliminado');
            }

            $currentStatus = (bool) $governmentAgency->is_active;
            $newStatus     = $currentStatus ? 0 : 1;

            DB::beginTransaction();

            $governmentAgency->update(['is_active' => $newStatus]);
            $governmentAgency->user->update(['is_active' => $newStatus]);

            DB::table('requirements')
                ->where('user_id', $governmentAgency->user->id)
                ->update(['is_active' => $newStatus]);

            DB::commit();
            return redirect()
                ->route("{$this->routeName}index")
                ->with('success', 'Estado de la dependencia actualizado con éxito');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()
                ->route("{$this->routeName}index")
                ->with('error', 'Ocurrió un error al actualizar el estado de la dependencia');
        }
    }

    public function exportPdf()
    {
        $this->authorize('users.exportFiles');

        $agencies = GovernmentAgency::with(['governmentLevel', 'governmentSector'])->get();
        $pdf = Pdf::loadView('Users.GovernmentAgencyUsersPDF', compact('agencies'));
        $date = now()->format('Y-m-d');
        return $pdf->download("usuarios_dependencia_gobierno_{$date}.pdf");
    }

    public function exportExcel()
    {
        $this->authorize('users.exportFiles');
        $date = now()->format('Y-m-d');
        return Excel::download(new GovernmentAgencyUsersExport, "usuarios_dependencia_gobierno_{$date}.xlsx");
    }
}
