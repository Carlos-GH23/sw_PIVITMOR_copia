<?php

namespace App\Http\Controllers\Admin\Users;

use App\Exports\NonProfitOrganizationUsersExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\NonProfitOrganizationResource;
use App\Models\NonProfitOrganization;
use App\Models\Requirement;
use App\Traits\Filterable;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class NonProfitOrganizationUsersController extends Controller
{
    use Filterable;
    protected string $routeName;
    protected string $source;

    public function __construct()
    {
        $this->routeName = "users.nonProfitOrganizationProfile.";
        $this->source    = "Core/Admin/Users/NonProfitOrganizations/Pages/";
        $this->middleware("permission:users.nonProfitOrganizationProfile")->only(['index', 'show']);
    }

    public function index(Request $request)
    {
        $filters = $this->getFiltersBase($request->query());
        $query = NonProfitOrganization::with(['logo', 'location', 'contact', 'user'])
            ->whereHas('user', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->when($filters->search, function ($query, $search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('description', 'LIKE', "%{$search}%")
                        ->orWhere('rfc', 'LIKE', "%{$search}%")
                        ->orWhere('legal_representative', 'LIKE', "%{$search}%");
                });
            })
            ->when($filters->withTrashed, function ($query) {
                $query->withTrashed();
            });

        $organizations = $query->orderBy($filters->order, $filters->direction)
            ->paginate($filters->rows)
            ->withQueryString();

        return Inertia::render("{$this->source}Index", [
            'title'     => 'Gestión de Organizaciones No Gubernamentales',
            'organizations'  => NonProfitOrganizationResource::collection($organizations),
            'routeName' => $this->routeName,
            'filters'   => $filters
        ]);
    }

    public function enable(NonProfitOrganization $nonProfitOrganization)
    {
        try {
            if (!$nonProfitOrganization->user || $nonProfitOrganization->user->trashed()) {
                return redirect()
                    ->route("{$this->routeName}index")
                    ->with('error', 'No se puede cambiar el estado: el usuario asociado ha sido eliminado');
            }

            $currentStatus = (bool) $nonProfitOrganization->is_active;
            $newStatus     = $currentStatus ? 0 : 1;

            DB::beginTransaction();

            $nonProfitOrganization->update(['is_active' => $newStatus]);
            $nonProfitOrganization->user->update(['is_active' => $newStatus]);
            Requirement::where('user_id', $nonProfitOrganization->user->id)
                ->update(['is_active' => $newStatus]);

            DB::commit();

            return redirect()
                ->route("{$this->routeName}index")
                ->with('success', 'Estado de la organización actualizado con éxito');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()
                ->route("{$this->routeName}index")
                ->with('error', 'Ocurrió un error al actualizar el estado de la organización');
        }
    }
 
    public function exportPdf()
    {
        $this->authorize('users.exportFiles');

        $organizations = NonProfitOrganization::all();
        $pdf = Pdf::loadView('Users.NonProfitOrganizationUsersPDF', compact('organizations'));
        $date = now()->format('Y-m-d');
        return $pdf->download("usuarios_organizacion_{$date}.pdf");
    }

    public function exportExcel()
    {
        $this->authorize('users.exportFiles');
        
        $date = now()->format('Y-m-d');
        return Excel::download(new NonProfitOrganizationUsersExport, "usuarios_organizacion_{$date}.xlsx");
    }
}
