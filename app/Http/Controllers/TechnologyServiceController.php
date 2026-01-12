<?php

namespace App\Http\Controllers;

use App\Models\TechnologyService;
use App\Http\Requests\StoreTechnologyServiceRequest;
use App\Http\Requests\UpdateTechnologyServiceRequest;
use App\Http\Resources\TechnologyServiceResource;
use App\Models\Institution\Department;
use App\Models\Academic;
use App\Traits\Filterable;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\ValidityTechnologyServiceRequest;
use App\Models\Catalogs\EconomicSector;
use App\Models\Catalogs\OecdSector;
use App\Models\Catalogs\TechnologyServiceCategory;
use App\Models\Catalogs\TechnologyServiceType;
use App\Models\Institution\Facility;
use App\Models\Institution\FacilityEquipment;
use App\Services\TechnologyServiceService;

class TechnologyServiceController extends Controller
{
    use Filterable;
    private TechnologyService $model;
    private string $source;
    private string $routeName;
    protected TechnologyServiceService $technologyServiceService;

    public function __construct(TechnologyServiceService $technologyServiceService)
    {
        $this->source = 'Shared/TechnologyServices/Pages/';
        $this->model = new TechnologyService();
        $this->routeName = 'technologyServices.';
        $this->technologyServiceService = $technologyServiceService;
        
        $this->middleware("permission:{$this->routeName}index")->only(['index', 'show']);
        $this->middleware("permission:{$this->routeName}store")->only(['store', 'create']);
        $this->middleware("permission:{$this->routeName}update")->only(['update', 'edit', 'validity']);
        $this->middleware("permission:{$this->routeName}delete")->only(['destroy']);
        $this->middleware("permission:{$this->routeName}enable")->only(['enable']);

        $this->authorizeResource(TechnologyService::class, 'technologyService');
    }

    public function index(Request $request): Response
    {
        $filters = $this->getFiltersBase($request->query());
        $query = $this->technologyServiceService->buildQuery($filters->search);
        $technologyServices = $this->technologyServiceService->buildFilters($query, $filters);

        return Inertia::render("{$this->source}Index", [
            'technologyServices'  => TechnologyServiceResource::collection($technologyServices),
            'title'     => 'Servicios Tecnológicos',
            'routeName' => $this->routeName,
            'filters'   => $filters
        ]);
    }

    public function create()
    {
        return Inertia::render("{$this->source}Create", array_merge([
            'title'     => 'Registrar servicio tecnológico',
            'routeName' => $this->routeName,
        ], $this->technologyServiceService->getFormData()));
    }

    public function store(StoreTechnologyServiceRequest $request)
    {
        try {
            $this->technologyServiceService->store($request->validated());
            return redirect()->route("{$this->routeName}index")->with('success', 'Servicio tecnológico creado con éxito');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return redirect()->route("{$this->routeName}index")->with('error', 'Ha ocurrido un error al intentar crear el registro');
        }
    }

    public function show(TechnologyService $technologyService)
    {
        $technologyService->load([
            'files',
            'photos',
            'oecdSectors',
            'economicSectors',
            'facilities',
            'equipments',
            'academics',
            'keywords',
            'assessments.user.photo',
            'department',
            'technologyServiceType',
            'technologyServiceCategory',
            'technologyServiceStatus'
        ]);
        return Inertia::render("{$this->source}Show", [
            'title'         => 'Consultar Servicio Tecnológico',
            'service'       => new TechnologyServiceResource($technologyService),
            'routeName'     => $this->routeName,
        ]);
    }

    public function edit(TechnologyService $technologyService)
    {
        $technologyService->load(
            'files',
            'photos',
            'oecdSectors',
            'economicSectors',
            'facilities',
            'equipments',
            'academics',
            'keywords',
            'assessments.user.photo'
        );
        return Inertia::render("{$this->source}Edit", array_merge([
            'title'     => 'Editar servicio tecnológico',
            'routeName' => $this->routeName,
            'service'   => new TechnologyServiceResource($technologyService)
        ], $this->technologyServiceService->getFormData()));
    }

    public function update(UpdateTechnologyServiceRequest $request, TechnologyService $technologyService)
    {
        try {
            $this->technologyServiceService->update($technologyService, $request->validated());
            return redirect()->route("{$this->routeName}index")->with('success', 'Servicio tecnológico actualizado con éxito');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return redirect()->route("{$this->routeName}index")->with('error', 'Ha ocurrido un error al intentar actualizar el registro');
        }
    }

    public function destroy(TechnologyService $technologyService)
    {
        try {
            $this->technologyServiceService->delete($technologyService);
            return redirect()->route("{$this->routeName}index")->with('success', 'Servicio tecnológico eliminado con éxito');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return redirect()->route("{$this->routeName}index")->with('error', 'Ha ocurrido un error al intentar eliminar el registro');
        }
    }

    public function enable(TechnologyService $technologyService)
    {
        $this->authorize('enable', $technologyService);
        
        try {
            DB::transaction(function () use ($technologyService) {
                $technologyService->is_active = $technologyService->is_active ? 0 : 1;
                $technologyService->save();
            });
            return back()->with('success', 'Servicio tecnológico actualizado con éxito');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return back()->with('error', 'Ha ocurrido un error al intentar actualizar el registro');
        }
    }

    public function validity(ValidityTechnologyServiceRequest $request, TechnologyService $technologyService)
    {
        $this->authorize('validity', $technologyService);
        $fields = $request->validated();

        try {
            DB::transaction(function () use ($fields, $technologyService) {
                $technologyService->update($fields);
            });
            return back()->with('success', 'Capacidad actualizada con éxito');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return back()->with('error', 'Ha ocurrido un error al intentar actualizar el registro');
        }
    }
}
