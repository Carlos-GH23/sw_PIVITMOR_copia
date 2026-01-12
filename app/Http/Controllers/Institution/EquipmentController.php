<?php

namespace App\Http\Controllers\Institution;

use App\Http\Resources\Institution\FacilityEquipmentResource;
use App\Http\Requests\Institution\UpdateEquipmentRequest;
use App\Http\Requests\Institution\StoreEquipmentRequest;
use App\Models\Institution\FacilityEquipment;
use Illuminate\Database\Eloquent\Model;
use App\Models\Catalogs\EquipmentType;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Traits\Filterable;
use App\Models\Academic;
use App\Services\EquipmentService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Http\JsonResponse;
use App\Models\Institution\Department;
use App\Traits\HasOrderableRelations;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class EquipmentController extends Controller

{
    use Filterable;
    use HasOrderableRelations;
    protected string $routeName;
    protected string $source;
    protected Model $model;
    protected EquipmentService $equipmentService;

    public function __construct(EquipmentService $equipmentService)
    {
        $this->routeName = "institutions.equipments.";
        $this->source    = "Domains/Institution/Equipment/Pages/";
        $this->model     = new FacilityEquipment();
        $this->equipmentService = $equipmentService;

        $this->middleware("permission:{$this->routeName}index")->only(['index', 'show']);
        $this->middleware("permission:{$this->routeName}store")->only(['store', 'create']);
        $this->middleware("permission:{$this->routeName}update")->only(['edit', 'update']);
        $this->middleware("permission:{$this->routeName}delete")->only(['destroy']);
        $this->middleware("permission:{$this->routeName}enable")->only(['enable']);

        $this->authorizeResource(FacilityEquipment::class, 'equipment');
    }

    public function index(Request $request)
    {

        $filters = $this->getFiltersBase($request->query());
        $query = $this->model->query()->with(['equipmentType', 'facility'])
            ->when($filters->search, function ($query, $search) {
                $query->where('facility_equipments.name', 'LIKE', '%' . $search . '%')
                    ->orWhere('facility_equipments.description', 'LIKE', '%' . $search . '%')
                    ->orWhereRelation('equipmentType', 'name', 'LIKE', '%' . $search . '%')
                    ->orWhereRelation('facility', 'name', 'LIKE', '%' . $search . '%')
                    ->orWhere(function ($subQuery) use ($search) {
                        $searchLower = strtolower($search);
                        if (str_contains($searchLower, 'activo') && !str_contains($searchLower, 'inactivo')) {
                            $subQuery->where('status', true);
                        } elseif (str_contains($searchLower, 'inactivo')) {
                            $subQuery->where('status', false);
                        }
                    });
            })
            ->institution();

        $this->applyOrdering($query, $filters->order, $filters->direction);
        $equipment = $query->paginate($filters->rows)->withQueryString();

        return Inertia::render("{$this->source}Index", [
            'title'           => 'Infraestructura tecnológica',
            'routeName'       => $this->routeName,
            'filters'         => $filters,
            'equipment'       => FacilityEquipmentResource::collection($equipment)
        ]);
    }

    public function create()
    {
        $user = Auth::user();
        $institutionId = $user->institution?->id ?? $user->academic?->department?->institution_id;
        return Inertia::render("{$this->source}Create", [
            'title'           => 'Registrar infraestructura tecnológica',
            'routeName'       => $this->routeName,
            'equipmentTypes'  => EquipmentType::select(['id', 'name'])->orderBy('name')->get(),
            'departments'     => Department::where('institution_id', $institutionId)->get(),
            'academics'        => Academic::select(['id', 'first_name', 'last_name', 'second_last_name'])
                ->whereHas('department', function ($q) use ($institutionId) {
                    $q->where('institution_id', $institutionId);
                })
                ->orderBy('first_name')->get()->map(function ($academic) {
                    return [
                        'id' => $academic->id,
                        'name' => $academic->full_name
                    ];
                }),
        ]);
    }

    public function store(StoreEquipmentRequest $request)
    {
        try {
            $this->equipmentService->store($request->validated());
            return redirect()->route("{$this->routeName}index")
                ->with('success', 'Infraestructura tecnológica creada correctamente.');
        } catch (\Exception $e) {
            return redirect()->route("{$this->routeName}index")
                ->with('error', 'Error al crear la infraestructura tecnológica');
        }
    }

    public function edit(FacilityEquipment $equipment)
    {
        $user = Auth::user();
        $institutionId = $user->institution?->id ?? $user->academic?->department?->institution_id;
        $equipment = $equipment->load(['photos', 'files', 'equipmentType', 'facility', 'responsible']);
        $equipment = new FacilityEquipmentResource($equipment);

        return Inertia::render("{$this->source}Edit", [
            'title'           => 'Editar infraestructura tecnológica',
            'routeName'       => $this->routeName,
            'facilityEquipment'       => $equipment,
            'equipmentTypes'  => EquipmentType::select(['id', 'name'])->orderBy('name')->get(),
            'departments'     => Department::get(),
            'academics'        => Academic::select(['id', 'first_name', 'last_name', 'second_last_name'])
                ->whereHas('department', function ($q) use ($institutionId) {
                    $q->where('institution_id', $institutionId);
                })
                ->orderBy('first_name')->get()->map(function ($academic) {
                    return [
                        'id' => $academic->id,
                        'name' => $academic->full_name
                    ];
                }),
        ]);
    }

    public function update(UpdateEquipmentRequest $request, FacilityEquipment $equipment)
    {
        try {
            $this->equipmentService->update($equipment, $request->validated());
            return redirect()->route("{$this->routeName}index")
                ->with('success', 'Infraestructura tecnológica actualizada correctamente.');
        } catch (\Exception $e) {
            return redirect()->route("{$this->routeName}index")
                ->with('error', 'Error al editar la infraestructura tecnológica');
        }
    }

    public function destroy(FacilityEquipment $equipment)
    {
        try {
            $this->equipmentService->destroy($equipment);
            return redirect()->route("{$this->routeName}index")
                ->with('success', 'Infraestructura tecnológica eliminada correctamente.');
        } catch (\Exception $e) {
            return redirect()->route("{$this->routeName}index")
                ->with('error', 'Error al eliminar la infraestructura tecnológica');
        }
    }

    public function getFacilitiesByDepartment(Department $department): JsonResponse
    {
        $facilities = $this->equipmentService->getFacilitiesByDepartment($department->id);

        return response()->json($facilities);
    }

    protected function getOrderableRelations(): array
    {
        return [
            'equipment_type' => ['equipment_types', 'equipment_type_id', 'name'],
            'facility' => ['facilities', 'facility_id', 'name'],
        ];
    }

    public function enable(FacilityEquipment $equipment)
    {
        $this->authorize('enable', $equipment);
        try {
            DB::transaction(function () use ($equipment) {
                $equipment->status = !$equipment->status;
                $equipment->save();
            });
            return back()->with('success', 'Estatus de la instalación actualizado con éxito.');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return back()->with('error', 'Ha ocurrido un error al actualizar el estatus.');
        }
    }
}
