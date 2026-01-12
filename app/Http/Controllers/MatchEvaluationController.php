<?php

namespace App\Http\Controllers;

use App\Enums\ImpactMetricAction;
use App\Models\MatchEvaluation;
use App\Http\Requests\StoreMatchEvaluationRequest;
use App\Http\Requests\UpdateMatchEvaluationRequest;
use App\Http\Resources\CapabilityRequirementMatchResource;
use App\Http\Resources\MatchEvaluationResource;
use App\Models\AcademicOfferings\AcademicOffering;
use App\Models\CapabilityRequirementMatch;
use App\Models\Catalogs\ImpactMetric;
use App\Models\Catalogs\MatchEvaluationCategory;
use App\Models\Catalogs\TechnologyLevel;
use App\Models\MatchEvaluationStatus;
use App\Services\MatchEvaluationService;
use App\Services\RequirementMatchService;
use App\Traits\Filterable;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class MatchEvaluationController extends Controller
{
    use Filterable;
    private string $source;
    private string $routeName;
    private string $routeBack;

    public function __construct(private RequirementMatchService $requirementMatchService, private MatchEvaluationService $matchEvaluationService)
    {
        $this->source = 'Shared/MatchEvaluations/Pages/';
        $this->routeName = 'matchEvaluations.';
        $this->routeBack = 'matches.evaluations.';

        $this->middleware("permission:{$this->routeName}index")->only(['index', 'show']);
        $this->middleware("permission:{$this->routeName}store")->only(['create', 'store']);
        $this->middleware("permission:{$this->routeName}update")->only(['edit', 'update']);
        $this->middleware("permission:{$this->routeName}enableSuccessStory")->only(['enableSuccessStory']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $filters = $this->getFiltersBase($request->query());

        $query = $this->matchEvaluationService->buildQuery($filters);
        $matchEvaluations = $this->matchEvaluationService->buildFilters($query, $filters);

        return Inertia::render("{$this->source}Index", [
            'matchEvaluations'          => MatchEvaluationResource::collection($matchEvaluations),
            'title'                     => 'Evaluaciones de vinculación para casos de éxito',
            'routeName'                 => $this->routeName,
            'filters'                   => $filters
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, CapabilityRequirementMatch $capabilityRequirementMatch)
    {
        $this->authorize('createMatchEvaluation', $capabilityRequirementMatch);

        $allowedImpactMetrics = ImpactMetricAction::allowed($capabilityRequirementMatch);
        return Inertia::render("{$this->source}Create", [
            'title'                         => 'Registrar evaluación de vinculación',
            'routeName'                     => $this->routeName,
            'routeBack'                     => $request->input('routeBack'),
            'categories'                    => MatchEvaluationCategory::getHierarchy(),
            'capabilityRequirementMatch'    => new CapabilityRequirementMatchResource($capabilityRequirementMatch),
            'actors'                        => $capabilityRequirementMatch->actors(),
            'impactMetrics'                 => ImpactMetric::all()->groupBy('type'),
            'technologyLevels'              => TechnologyLevel::select(['id', 'name', 'level'])->orderBy('level')->get(),
            'academicOfferings'             => AcademicOffering::institutionByAcademic()->get(),
            'matchEvaluationStatuses'       => MatchEvaluationStatus::all(),
            'allowedImpactMetrics'          => $allowedImpactMetrics,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CapabilityRequirementMatch $capabilityRequirementMatch, StoreMatchEvaluationRequest $request)
    {
        $this->authorize('createMatchEvaluation', $capabilityRequirementMatch);

        try {
            $this->matchEvaluationService->store($request->validated(), $capabilityRequirementMatch);

            return redirect()->route($request->input('routeBack'))->with('success', 'Formulario de evaluación guardado con éxito');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return back()->with('error', 'Ha ocurrido un error al intentar crear el registro');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(MatchEvaluation $matchEvaluation)
    {
        $matchEvaluation->load([
            'categories',
            'impactMetrics',
            'metricIndicators',
            'technologyLevelTransitions',
            'studentParticipations',
            'testimonials',
            'partnershipAgreements',
            'institutionalRecognitions',
            'derivedPolicies',
            'academicOfferings',
        ]);

        $allowedImpactMetrics = ImpactMetricAction::allowedForAdmin();

        return Inertia::render("{$this->source}Show", [
            'title'                         => 'Evaluación de vinculación',
            'routeName'                     => $this->routeName,
            'categories'                    => MatchEvaluationCategory::getHierarchy(),
            'matchEvaluation'               => new MatchEvaluationResource($matchEvaluation),
            'capabilityRequirementMatch'    => new CapabilityRequirementMatchResource($matchEvaluation->match),
            'actors'                        => $matchEvaluation->match->actors(),
            'impactMetrics'                 => ImpactMetric::all()->groupBy('type'),
            'technologyLevels'              => TechnologyLevel::select(['id', 'name'])->orderBy('level')->get(),
            'academicOfferings'             => AcademicOffering::institutionByAcademic()->get(),
            'matchEvaluationStatuses'       => MatchEvaluationStatus::all(),
            'allowedImpactMetrics'          => $allowedImpactMetrics,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, MatchEvaluation $matchEvaluation)
    {
        $this->authorize('update', $matchEvaluation);

        $matchEvaluation->load([
            'categories',
            'impactMetrics',
            'metricIndicators',
            'technologyLevelTransitions',
            'studentParticipations',
            'testimonials',
            'partnershipAgreements',
            'institutionalRecognitions',
            'derivedPolicies',
            'academicOfferings',
        ]);

        $allowedImpactMetrics = ImpactMetricAction::allowed($matchEvaluation->match);

        return Inertia::render("{$this->source}Edit", [
            'title'                         => 'Editar evaluación vinculación',
            'routeName'                     => $this->routeName,
            'routeBack'                     => $request->input('routeBack'),
            'categories'                    => MatchEvaluationCategory::getHierarchy(),
            'matchEvaluation'               => new MatchEvaluationResource($matchEvaluation),
            'capabilityRequirementMatch'    => new CapabilityRequirementMatchResource($matchEvaluation->match),
            'actors'                        => $matchEvaluation->match->actors(),
            'impactMetrics'                 => ImpactMetric::all()->groupBy('type'),
            'technologyLevels'              => TechnologyLevel::select(['id', 'name'])->orderBy('level')->get(),
            'academicOfferings'             => AcademicOffering::institutionByAcademic()->get(),
            'matchEvaluationStatuses'       => MatchEvaluationStatus::all(),
            'allowedImpactMetrics'          => $allowedImpactMetrics,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMatchEvaluationRequest $request, MatchEvaluation $matchEvaluation)
    {
        $this->authorize('update', $matchEvaluation);

        try {
            $this->matchEvaluationService->update($request->validated(), $matchEvaluation);

            return redirect()->route($request->input('routeBack'))->with('success', 'Formulario de evaluación actualizado con éxito');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return redirect()->route("{$this->routeName}index")->with('error', 'Ha ocurrido un error al intentar actualizar el registro');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MatchEvaluation $matchEvaluation)
    {
        abort(404);
    }

    public function enableSuccessStory(MatchEvaluation $matchEvaluation)
    {
        try {
            $matchEvaluation->is_success_story = $matchEvaluation->is_success_story ? 0 : 1;
            $matchEvaluation->save();

            return back()->with('success', 'Evaluación marcada como historia de éxito');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return back()->with('error', 'Ha ocurrido un error al intentar actualizar el registro');
        }
    }
}
