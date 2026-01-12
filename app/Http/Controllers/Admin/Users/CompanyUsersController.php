<?php

namespace App\Http\Controllers\Admin\Users;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company\Company;
use App\Http\Resources\Company\CompanyResource;
use App\Traits\Filterable;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Exports\CompanyUsersExport;
use App\Models\Company\JobOffer;
use App\Models\Requirement;
use App\Models\TechnologyService;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class CompanyUsersController extends Controller
{
    use Filterable;
    protected string $routeName;
    protected string $source;

    public function __construct()
    {
        $this->routeName = "users.companyProfile.";
        $this->source    = "Core/Admin/Users/Companies/Pages/";

        $this->middleware("permission:users.companyProfile")->only(['index', 'show']);
    }

    public function index(Request $request)
    {
        $filters = $this->getFiltersBase($request->query());
        $query = Company::with(['logo', 'location', 'keywords', 'contact', 'reniecyt', 'user'])
            ->whereHas('user', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->when($filters->search, function ($query, $search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('legal_name', 'LIKE', "%{$search}%")
                        ->orWhere('rfc', 'LIKE', "%{$search}%")
                        ->orWhere('year', 'LIKE', "%{$search}%");
                });
            })
            ->when($filters->withTrashed, function ($query) {
                $query->withTrashed();
            });

        $companies = $query->orderBy($filters->order, $filters->direction)
            ->paginate($filters->rows)
            ->withQueryString();

        return Inertia::render("{$this->source}Index", [
            'title'     => 'Gestión de Empresas',
            'companies' => CompanyResource::collection($companies),
            'routeName' => $this->routeName,
            'filters'   => $filters
        ]);
    }

    public function enable(Company $company)
    {
        try {
            if (!$company->user || $company->user->trashed()) {
                return redirect()
                    ->route("{$this->routeName}index")
                    ->with('error', 'No se puede cambiar el estado: el usuario asociado ha sido eliminado');
            }

            $currentStatus = (bool) $company->is_active;
            $newStatus     = $currentStatus ? 0 : 1;

            DB::beginTransaction();

            $company->update(['is_active' => $newStatus]);
            $company->user->update(['is_active' => $newStatus]);

            JobOffer::where('user_id', $company->user->id)
                ->update(['is_active' => $newStatus]);

            Requirement::where('user_id', $company->user->id)
                ->update(['is_active' => $newStatus]);

            TechnologyService::where('user_id', $company->user->id)
                ->update(['is_active' => $newStatus]);

            $techCompany = $company->technologyCompany;
            if ($techCompany) {
                $techCompany->update(['is_active' => $newStatus]);
            }

            DB::commit();
            return redirect()
                ->route("{$this->routeName}index")
                ->with('success', 'Estado de la empresa actualizado con éxito');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            return redirect()
                ->route("{$this->routeName}index")
                ->with('error', 'Ocurrió un error al actualizar el estado de la empresa');
        }
    }
    
    public function exportPdf()
    {
        $this->authorize('users.exportFiles');
        $companies = Company::with(['logo'])->get();
        $pdf = Pdf::loadView('Users.CompanyUsersPDF', compact('companies'));
        $date = now()->format('Y-m-d');
        return $pdf->download("usuarios_empresa_{$date}.pdf");
    }

    public function exportExcel()
    {
        $this->authorize('users.exportFiles');
        $date = now()->format('Y-m-d');
        return Excel::download(new CompanyUsersExport, "usuarios_empresa_{$date}.xlsx");
    }
}
