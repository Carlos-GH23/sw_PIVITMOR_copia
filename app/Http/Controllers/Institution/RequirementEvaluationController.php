<?php

namespace App\Http\Controllers\Institution;

use App\Events\MatchingShouldRun;
use App\Http\Controllers\Controller;
use App\Http\Requests\Evaluation\StoreRequirementEvaluationRequest;
use App\Http\Resources\RequirementResource;
use App\Models\Requirement;
use App\Notifications\EvaluationNotification;
use App\Services\RequirementService;
use App\Traits\Filterable;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class RequirementEvaluationController extends Controller
{
    use Filterable;
    private string $source;
    private string $routeName;

    public function __construct(private RequirementService $requirementService)
    {
        $this->source = 'Domains/Institution/Evaluations/Requirements/Pages/';
        $this->routeName = 'requirements.evaluations.';

        $this->middleware("permission:{$this->routeName}index")->only(['index', 'show']);
        $this->middleware("permission:{$this->routeName}store")->only(['create', 'store']);
    }

    public function index(Request $request): Response
    {
        $filters = $this->getFiltersBase($request->query());
        $query = $this->requirementService->buildQuery($filters);
        $query->status(2);
        $requirements = $this->requirementService->buildFilters($query, $filters);

        return Inertia::render("{$this->source}Index", [
            'requirements'  => RequirementResource::collection($requirements),
            'title'         => 'Evaluación de Necesidades Tecnológicas',
            'routeName'     => $this->routeName,
            'filters'       => $filters
        ]);
    }

    public function create(Requirement $requirement): Response
    {
        $this->authorize('evaluation', $requirement);
        $requirement->load(
            'photos',
            'keywords',
            'oecdSectors',
            'economicSectors',
            'department',
            'technologyLevel',
            'intellectualProperty',
            'oecdSectors',
            'economicSectors',
            'assessments.user',
        );
        return Inertia::render("{$this->source}Create", [
            'title'         => 'Evaluar Necesidad Tecnológica',
            'routeName'     => $this->routeName,
            'requirement'   => new RequirementResource($requirement)
        ]);
    }

    public function store(StoreRequirementEvaluationRequest $request, Requirement $requirement)
    {
        $this->authorize('evaluation', $requirement);
        try {
            $requirement->assessments()->create($request->validated());
            $requirement->update($request->validated());
            event(new MatchingShouldRun($requirement));


            $requirement->user->notify(new EvaluationNotification($requirement));
            return redirect()->route("{$this->routeName}index")->with('success', 'Necesidad tecnológica evaluada con éxito');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return redirect()->route("{$this->routeName}index")->with('error', 'Ha ocurrido un error al evaluar la necesidad');
        }
    }
}
