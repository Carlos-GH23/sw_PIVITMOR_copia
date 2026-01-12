<?php

namespace App\Http\Controllers;

use App\Http\Resources\CapabilityRequirementMatchResource;
use App\Models\Capability;
use App\Models\CapabilityRequirementMatch;
use App\Models\Requirement;
use App\Notifications\MatchResponseNotification;
use App\Services\RequirementMatchService;
use App\Traits\ApiResponse;
use App\Traits\Filterable;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class RequirementMatchController extends Controller
{
    use Filterable;
    use ApiResponse;
    private string $source;
    private string $routeName;

    public function __construct(private RequirementMatchService $requirementMatchService)
    {
        $this->source = 'Shared/Matches/Requirements/Pages/';
        $this->routeName = 'requirements.matches.';

        $this->middleware("permission:{$this->routeName}index")->only(['index']);
        $this->middleware("permission:{$this->routeName}store")->only(['accept', 'reject']);
        $this->authorizeResource(CapabilityRequirementMatch::class, 'capabilityRequirementMatch');
    }

    public function index(Request $request): Response
    {
        $filters = $this->getFiltersBase($request->query());
        $relations = [
            'requirement',
            'capability.user.academic.department.institution',
            'matchStatus',
            'applicantEvaluation.matchEvaluationStatus',
        ];

        $query = $this->requirementMatchService->queryRequirement($filters, $relations);
        $matches = $this->requirementMatchService->buildFilters($query, $filters);

        return Inertia::render("{$this->source}Index", [
            'matches'       => CapabilityRequirementMatchResource::collection($matches),
            'title'         => 'Vinculación de necesidades tecnológicas',
            'routeName'     => $this->routeName,
            'filters'       => $filters
        ]);
    }

    public function match(CapabilityRequirementMatch $capabilityRequirementMatch)
    {
        $capabilityRequirementMatch->load([
            'capability.photos',
            'capability.files',
            'capability.keywords',
            'capability.department',
            'capability.intellectualProperty',
            'capability.technologyLevel',
            'capability.oecdSectors',
            'capability.economicSectors',
            'capability.academics.department',
            'capability.academics.academicPosition',
            'capability.academics.photo',
        ]);

        $capabilityRequirementMatch->capability->loadAndMountEntity();
        return $this->success(new CapabilityRequirementMatchResource($capabilityRequirementMatch));
    }

    public function accept(CapabilityRequirementMatch $capabilityRequirementMatch)
    {
        $this->authorize('matchRequirement', $capabilityRequirementMatch);

        try {
            $this->requirementMatchService->accept($capabilityRequirementMatch);
            $capabilityRequirementMatch->capability->user->notify(
                new MatchResponseNotification($capabilityRequirementMatch, $capabilityRequirementMatch->requirement)
            );
            return back()->with('success', 'Vinculación evaluada con éxito');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return back()->with('error', 'Ha ocurrido un error al evaluar la vinculación');
        }
    }

    public function reject(CapabilityRequirementMatch $capabilityRequirementMatch)
    {
        $this->authorize('matchRequirement', $capabilityRequirementMatch);

        try {
            $this->requirementMatchService->reject($capabilityRequirementMatch);
            $capabilityRequirementMatch->capability->user->notify(
                new MatchResponseNotification($capabilityRequirementMatch, $capabilityRequirementMatch->requirement)
            );
            return back()->with('success', 'Vinculación evaluada con éxito');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return back()->with('error', 'Ha ocurrido un error al evaluar la vinculación');
        }
    }

    public function test(Requirement $requirement, Capability $capability)
    {
        CapabilityRequirementMatch::create([
            'compatibility_score' => 0.90,
            'requirement_id' => $requirement->id,
            'capability_id' => $capability->id,
        ]);
    }
}
