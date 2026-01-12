<?php


namespace App\Http\Controllers\Institution;

use App\Events\MatchingShouldRun;
use App\Models\Capability;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCapabilityEvaluationRequest;
use App\Http\Resources\CapabilityResource;
use App\Notifications\EvaluationNotification;
use App\Services\CapabilityService;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Exception;
use Illuminate\Support\Facades\Log;

class CapabilityEvaluationController extends Controller
{
    use Filterable;
    private string $routeName;
    private string $source;
    private Model $model;

    public function __construct(private CapabilityService $capabilityService)
    {
        $this->routeName = "capabilities.evaluations.";
        $this->source    = "Domains/Institution/Evaluations/Capabilities/Pages/";
        $this->model     = new Capability();

        $this->middleware("permission:{$this->routeName}index")->only(['index', 'show']);
        $this->middleware("permission:{$this->routeName}store")->only(['store', 'create']);
    }

    public function index(Request $request)
    {
        $filters = $this->getFiltersBase($request->query());
        $query = $this->capabilityService->buildQuery($filters->search);
        $query->status(2);

        $capabilities = $this->capabilityService->buildFilters($query, $filters);

        return Inertia::render("{$this->source}Index", [
            'title'     => 'Evaluación de capacidades tecnológicas',
            'capabilities' => CapabilityResource::collection($capabilities),
            'routeName' => $this->routeName,
            'filters'   => $filters
        ]);
    }

    public function create(Capability $capability)
    {
        $this->authorize('create', ['CapabilityEvaluation', $capability]);

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

        return Inertia::render("{$this->source}Create", [
            'title'     => 'Evaluar capacidad tecnológica',
            'routeName' => $this->routeName,
            'capability' => new CapabilityResource($capability),
        ]);
    }

    public function store(StoreCapabilityEvaluationRequest $request, Capability $capability)
    {
        $this->authorize('create', ['CapabilityEvaluation', $capability]);

        try {
            $capability->assessments()->create($request->validated());
            $capability->update(['capability_status_id' => $request->input('capability_status_id')]);
            $capability->user->notify(new EvaluationNotification($capability));
            event(new MatchingShouldRun($capability));

            return redirect()->route("{$this->routeName}index")->with('success', 'Evaluación creada con éxito');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return redirect()->route("{$this->routeName}index")->with('error', 'Ha ocurrido un error al crear el registro');
        }
    }
}
