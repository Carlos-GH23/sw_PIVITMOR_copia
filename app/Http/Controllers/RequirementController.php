<?php

namespace App\Http\Controllers;

use App\Events\MatchingShouldRun;
use App\Models\Requirement;
use App\Http\Requests\StoreRequirementRequest;
use App\Http\Requests\UpdateRequirementRequest;
use App\Http\Requests\ValidityCapabilityRequest;
use App\Http\Resources\RequirementResource;
use App\Models\Catalogs\EconomicSector;
use App\Models\Catalogs\IntellectualProperty;
use App\Models\Catalogs\OecdSector;
use App\Models\Catalogs\TechnologyLevel;
use App\Models\Institution\Department;
use App\Services\PhotoService;
use App\Services\RequirementService;
use App\Traits\Filterable;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class RequirementController extends Controller
{
    use Filterable;
    private Model $model;
    private string $source;
    private string $routeName;
    protected RequirementService $requirementService;
    protected PhotoService $photoService;

    public function __construct(RequirementService $requirementService, PhotoService $photoService)
    {
        $this->source = 'Shared/Requirements/Pages/';
        $this->model = new Requirement();
        $this->routeName = 'requirements.';
        $this->requirementService = $requirementService;
        $this->photoService = $photoService;

        $this->middleware("permission:{$this->routeName}index")->only(['index', 'show']);
        $this->middleware("permission:{$this->routeName}store")->only(['store', 'create']);
        $this->middleware("permission:{$this->routeName}update")->only(['update', 'edit', 'validity']);
        $this->middleware("permission:{$this->routeName}delete")->only(['destroy']);
        $this->middleware("permission:{$this->routeName}enable")->only(['enable']);

        $this->authorizeResource(Requirement::class, 'requirement');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $filters = $this->getFiltersBase($request->query());
        $query = $this->requirementService->buildQuery($filters);
        $requirements = $this->requirementService->buildFilters($query, $filters);

        return Inertia::render("{$this->source}Index", [
            'requirements'  => RequirementResource::collection($requirements),
            'title'         => 'Necesidades Tecnológicas',
            'routeName'     => $this->routeName,
            'filters'       => $filters
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $department = Department::where('id', Auth::user()->academic?->department_id)->first();

        return Inertia::render("{$this->source}Create", [
            'title'             => 'Agregar Necesidad Tecnológica',
            'department'        => $department,
            'intellectuals'     => IntellectualProperty::orderBy('name')->get(),
            'technologies'      => TechnologyLevel::orderBy('level')->get(),
            'oecdSectors'       => OecdSector::getHierarchy(),
            'economicSectors'   => EconomicSector::getHierarchy(),
            'routeName'         => $this->routeName,
        ]);
    }

    /**ñ
     * Store a newly created resource in storage.
     */
    public function store(StoreRequirementRequest $request)
    {
        try {
            $requirement = $this->requirementService->store($request->validated());
            event(new MatchingShouldRun($requirement));

            return redirect()->route("{$this->routeName}index")->with('success', 'Necesidad tecnológica creada con éxito');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return redirect()->route("{$this->routeName}index")->with('error', 'Ha ocurrido un error al intentar crear el registro');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Requirement $requirement)
    {
        $requirement->load([
            'photos',
            'keywords',
            'oecdSectors',
            'economicSectors',
            'assessments',
            'department',
            'intellectualProperty',
            'technologyLevel',
        ]);
        return Inertia::render("{$this->source}Show", [
            'title'         => 'Consultar Necesidad Tecnológica',
            'requirement'   => new RequirementResource($requirement),
            'routeName'     => $this->routeName,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Requirement $requirement)
    {
        $requirement->load(
            'photos',
            'keywords',
            'oecdSectors',
            'economicSectors',
            'assessments'
        );
        $department = Department::where('id', Auth::user()->academic?->department_id)->first();

        return Inertia::render("{$this->source}Edit", [
            'title'             => 'Editar Necesidad Tecnológica',
            'routeName'         => $this->routeName,
            'department'        => $department,
            'intellectuals'     => IntellectualProperty::orderBy('name')->get(),
            'technologies'      => TechnologyLevel::orderBy('level')->get(),
            'oecdSectors'       => OecdSector::getHierarchy(),
            'economicSectors'   => EconomicSector::getHierarchy(),
            'requirement'       => new RequirementResource($requirement)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequirementRequest $request, Requirement $requirement)
    {
        try {
            $requirement = $this->requirementService->update($requirement, $request->validated());
            event(new MatchingShouldRun($requirement));

            return redirect()->route("{$this->routeName}index")->with('success', 'Necesidad tecnológica actualizada con éxito');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return redirect()->route("{$this->routeName}index")->with('error', 'Ha ocurrido un error al intentar actualizar el registro');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Requirement $requirement)
    {
        try {
            $this->requirementService->delete($requirement);

            return redirect()->route("{$this->routeName}index")->with('success', 'Necesidad eliminada con éxito');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return redirect()->route("{$this->routeName}index")->with('error', 'Ha ocurrido un error al intentar eliminar el registro');
        }
    }

    public function enable(Requirement $requirement)
    {
        $this->authorize('enable', $requirement);

        try {
            $requirement->is_active = $requirement->is_active ? 0 : 1;
            $requirement->save();
            return redirect()->route("{$this->routeName}index")->with('success', 'Necesidad actualizada con éxito');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return redirect()->route("{$this->routeName}index")->with('error', 'Ha ocurrido un error al intentar actualizar el registro');
        }
    }

    public function validity(ValidityCapabilityRequest $request, Requirement $requirement)
    {
        $this->authorize('validity', $requirement);

        try {
            DB::transaction(function () use ($request, $requirement) {
                $requirement->update($request->validated());
            });
            return redirect()->route("{$this->routeName}index")->with('success', 'Periodo actualizado con éxito');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return redirect()->route("{$this->routeName}index")->with('error', 'Ha ocurrido un error al intentar actualizar el registro');
        }
    }
}
