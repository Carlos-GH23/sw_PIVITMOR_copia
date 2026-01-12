<?php

namespace App\Http\Controllers;

use App\Models\OrganizationRegistration;
use App\Models\OrganizationRegistrationStatus;
use App\Http\Resources\OrganizationRegistrationResource;
use App\Enums\OrganizationType;
use App\Traits\Filterable;
use App\Traits\HasOrderableRelations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class RequestController extends Controller
{
    use Filterable, HasOrderableRelations;

    private Model $model;
    private string $source;
    private string $routeName;

    public function __construct()
    {
        $this->source = 'Core/Admin/Requests/Pages/';
        $this->model = new OrganizationRegistration();
        $this->routeName = 'requests.';
    }

    protected function getOrderableRelations(): array
    {
        return [
            'status' => ['organization_registration_statuses', 'organization_registration_status_id', 'name'],
            'state' => ['states', 'state_id', 'name'],
            'municipality' => ['municipalities', 'municipality_id', 'name'],
        ];
    }

    public function index(Request $request): Response
    {
        $filters = $this->getFiltersBase($request->query());
        $filters->organization_type = $request->query('organization_type', null);

        $query = $this->model->with([
            'organizationRegistrationStatus',
            'municipality.state',
            'state'
        ])->when($filters->search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('organization_registrations.name', 'like', "%{$search}%")
                    ->orWhere('organization_registrations.email', 'like', "%{$search}%")
                    ->orWhere('organization_registrations.organization_type', 'like', "%{$search}%")
                    ->orWhereRelation('state', 'name', 'like', "%{$search}%")
                    ->orWhereRelation('municipality', 'name', 'like', "%{$search}%")
                    ->orWhereRelation('organizationRegistrationStatus', 'name', 'like', "%{$search}%");
            });
        })->when($filters->organization_type, function ($query, $organizationType) {
            $query->where('organization_registrations.organization_type', $organizationType);
        });

        $this->applyOrdering($query, $filters->order ?? 'created_at', $filters->direction ?? 'desc');

        $organizationRegistrations = $query->paginate($filters->rows ?? 5)->withQueryString();

        return Inertia::render("{$this->source}Index", [
            'title' => 'Solicitudes de Registro',
            'organizationRegistrations' => OrganizationRegistrationResource::collection($organizationRegistrations),
            'organizationTypes' => OrganizationType::toSelectArray(),
            'routeName' => $this->routeName,
            'filters' => $filters,
        ]);
    }

    public function updateStatus(Request $request, OrganizationRegistration $registration): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'status' => 'required|in:Aceptada,Rechazada',
                'rejection_reason' => 'required_if:status,Rechazada|nullable|string|max:2000',
            ]);

            $status = OrganizationRegistrationStatus::where('name', $validated['status'])->first();

            if (!$status) {
                return back()->with('error', 'Estado no válido');
            }

            DB::transaction(function () use ($registration, $status, $validated) {
                $registration->organization_registration_status_id = $status->id;
                $registration->rejection_reason = $validated['rejection_reason'] ?? null;
                $registration->save();
            });

            return back()->with('success', 'Estado actualizado con éxito');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return back()->with('error', 'Ha ocurrido un error al actualizar el estado');
        }
    }
}
