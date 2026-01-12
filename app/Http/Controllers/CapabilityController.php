<?php

namespace App\Http\Controllers;

use App\Events\MatchingShouldRun;
use App\Models\Capability;
use App\Http\Requests\StoreCapabilityRequest;
use App\Http\Requests\UpdateCapabilityRequest;
use App\Http\Requests\ValidityCapabilityRequest;
use App\Http\Resources\CapabilityResource;
use App\Services\CapabilityService;
use App\Traits\Filterable;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class CapabilityController extends Controller
{
    use Filterable;
    private string $routeName;
    private string $source;
    private Model $model;

    public function __construct(private CapabilityService $capabilityService)
    {
        $this->routeName = "capabilities.";
        $this->source    = "Domains/Institution/Capabilities/Pages/";
        $this->model     = new Capability();
        $this->middleware("permission:{$this->routeName}index")->only(['index', 'show']);
        $this->middleware("permission:{$this->routeName}store")->only(['store', 'create']);
        $this->middleware("permission:{$this->routeName}update")->only(['edit', 'update', 'validity']);
        $this->middleware("permission:{$this->routeName}delete")->only(['destroy']);
        $this->middleware("permission:{$this->routeName}enable")->only(['enable']);

        $this->authorizeResource(Capability::class, 'capability');
    }

    public function index(Request $request): Response
    {
        $filters = $this->getFiltersBase($request->query());
        $query = $this->capabilityService->buildQuery($filters->search);
        $capabilities = $this->capabilityService->buildFilters($query, $filters);

        return Inertia::render("{$this->source}Index", [
            'title'     => 'Capacidades tecnológicas',
            'capabilities' => CapabilityResource::collection($capabilities),
            'routeName' => $this->routeName,
            'filters'   => $filters
        ]);
    }

    public function create()
    {
        return Inertia::render("{$this->source}Create", array_merge([
            'title'     => 'Registrar capacidad tecnológica',
            'routeName' => $this->routeName,
        ], $this->capabilityService->getFormData()));
    }

    public function store(StoreCapabilityRequest $request)
    {
        $fields = $request->validated();

        try {
            $capability = $this->capabilityService->store($fields);
            event(new MatchingShouldRun($capability));

            return redirect()->route("{$this->routeName}index")->with('success', 'Capacidad creada con éxito');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return redirect()->route("{$this->routeName}index")->with('error', 'Ha ocurrido un error al crear el registro');
        }
    }

    public function show(Capability $capability)
    {
        $capability->load([
            'academics.department',
            'academics.academicPosition',
            'academics.photo',
            'assessments.user.photo',
            'department',
            'economicSectors',
            'files',
            'intellectualProperty',
            'keywords',
            'oecdSectors',
            'photos',
            'technologyLevel',
        ]);

        return Inertia::render("{$this->source}Show", [
            'title'     => 'Consultar capacidad tecnológica',
            'routeName' => $this->routeName,
            'capability' => new CapabilityResource($capability),
        ]);
    }

    public function edit(Capability $capability)
    {
        $capability->load([
            'files',
            'photos',
            'academics',
            'oecdSectors',
            'economicSectors',
            'assessments.user.photo'
        ]);

        return Inertia::render("{$this->source}Edit", array_merge([
            'title'     => 'Editar capacidad tecnológica',
            'routeName' => $this->routeName,
            'capability' => new CapabilityResource($capability),
        ], $this->capabilityService->getFormData()));
    }

    public function update(UpdateCapabilityRequest $request, Capability $capability)
    {
        $fields = $request->validated();

        try {
            $capability = $this->capabilityService->update($capability, $fields);
            event(new MatchingShouldRun($capability));

            return redirect()->route("{$this->routeName}index")->with('success', 'Capacidad actualizada con éxito');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return redirect()->route("{$this->routeName}index")->with('error', 'Ha ocurrido un error al actualizar el registro');
        }
    }

    public function destroy(Capability $capability)
    {
        try {
            $this->capabilityService->destroy($capability);
            return redirect()->route("{$this->routeName}index")->with('success', 'Capacidad eliminada con éxito');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return redirect()->route("{$this->routeName}index")->with('error', 'Ha ocurrido un error al intentar eliminar el registro');
        }
    }

    public function enable(Capability $capability)
    {
        $this->authorize('enable', $capability);

        try {
            DB::transaction(function () use ($capability) {
                $capability->is_active = $capability->is_active ? 0 : 1;
                $capability->save();
            });
            return back()->with('success', 'Capacidad actualizada con éxito');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return back()->with('error', 'Ha ocurrido un error al intentar actualizar el registro');
        }
    }

    public function validity(ValidityCapabilityRequest $request, Capability $capability)
    {
        $this->authorize('validity', $capability);
        $fields = $request->validated();

        try {
            DB::transaction(function () use ($fields, $capability) {
                $capability->update($fields);
            });
            return back()->with('success', 'Capacidad actualizada con éxito');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return back()->with('error', 'Ha ocurrido un error al intentar actualizar el registro');
        }
    }
}
