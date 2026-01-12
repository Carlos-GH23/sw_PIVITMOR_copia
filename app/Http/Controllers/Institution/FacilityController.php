<?php

namespace App\Http\Controllers\Institution;

use App\Http\Requests\Institution\StoreFacilityRequest;
use App\Http\Requests\Institution\UpdateFacilityRequest;
use App\Http\Resources\Institution\FacilityResource;
use App\Models\Institution\FacilityEquipment;
use Illuminate\Database\Eloquent\Model;
use App\Models\Catalogs\FacilityType;
use App\Models\Institution\Facility;
use App\Http\Controllers\Controller;
use App\Services\CSVImportService;
use App\Services\FacilityService;
use Illuminate\Http\Request;
use App\Traits\Filterable;
use Inertia\Inertia;
use App\Models\Institution\Department;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FacilityController extends Controller
{
    use Filterable;
    protected string $routeName;
    protected string $source;
    protected Model $model;
    protected FacilityService $facilityService;
    protected CSVImportService $csvImportService;

    public function __construct(FacilityService $facilityService, CSVImportService $csvImportService)
    {
        $this->routeName = "institutions.facilities.";
        $this->source    = "Domains/Institution/Facility/Pages/";
        $this->model     = new Facility();
        $this->facilityService = $facilityService;
        $this->csvImportService=$csvImportService;

        $this->middleware("permission:{$this->routeName}index")->only(['index', 'show']);
        $this->middleware("permission:{$this->routeName}store")->only(['store', 'create', 'uploadCSV']);
        $this->middleware("permission:{$this->routeName}update")->only(['edit', 'update']);
        $this->middleware("permission:{$this->routeName}delete")->only(['destroy']);
        $this->middleware("permission:{$this->routeName}enable")->only(['enable']);

        $this->authorizeResource(Facility::class, 'facility');
    }

    public function index(Request $request)
    {
        $filters = $this->getFiltersBase($request->query());
        $facilities = $this->facilityService->buildQuery($filters);

        return Inertia::render("{$this->source}Index", [
            'facilities'      => FacilityResource::collection($facilities),
            'title'           => 'Gestión de Instalaciones',
            'routeName'       => $this->routeName,
            'filters'         => $filters,
            'model_class'     => 'institution\\Facility',
        ]);
    }

    public function create()
    {
        return Inertia::render("{$this->source}Create", [
            'title'     => 'Registrar Instalación especializada',
            'routeName' => $this->routeName,
            'facilityTypes' => FacilityType::query()->get(['id', 'name']),
            'departments' => Department::query()->where('is_active', true)->institution()->get(['id', 'name']),
        ]);
    }

    public function store(StoreFacilityRequest $request)
    {
        try{
            $this->facilityService->store($request->validated());
            return redirect()->route("{$this->routeName}index")
            ->with('success', 'Instalación creada exitosamente.');
        }
        catch(Exception $e){
            return redirect()->route("{$this->routeName}index")
                ->with('error', 'Error al crear la instalación');
        }
    }

    public function edit(Facility $facility)
    {
        $facility->load(['photos', 'files', 'facilityType', 'department', 'equipments']);
        $facility = new FacilityResource($facility);

        return Inertia::render("{$this->source}Edit", [
            'title'     => 'Editar Instalación especializada',
            'routeName' => $this->routeName,
            'facility'  => $facility,
            'facilityTypes' => FacilityType::query()->get(['id', 'name']),
            'departments' => Department::query()->where('is_active', true)->institution()->get(['id', 'name']),
        ]);
    }

    public function update(UpdateFacilityRequest $request, Facility $facility)
    {
        try {
            $this->facilityService->update($facility, $request->validated());
            return redirect()->route("{$this->routeName}index")
                ->with('success', 'Instalación actualizada exitosamente.');
        }catch(Exception $e){
            return redirect()->route("{$this->routeName}index")
                ->with('error', 'Error al actualizar la instalación');
        }
    }

    public function destroy(Facility $facility)
    {
        try{
            $this->facilityService->destroy($facility);
            return redirect()->route("{$this->routeName}index")
                ->with('success', 'Instalación eliminada exitosamente.');
        }catch(Exception $e){
            return redirect()->route("{$this->routeName}index")
                ->with('error', 'Error al eliminar la instalación');
        }
    }

    public function enable(Facility $facility)
    {
        $this->authorize('enable', $facility);
        try {
            DB::transaction(function () use ($facility) {
                $facility->is_active = !$facility->is_active;
                $facility->save();
            });
            return back()->with('success', 'Estatus de la instalación actualizado con éxito.');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return back()->with('error', 'Ha ocurrido un error al actualizar el estatus.');
        }
    }
}
