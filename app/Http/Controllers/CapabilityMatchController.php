<?php

namespace App\Http\Controllers;

use App\Http\Resources\CapabilityRequirementMatchResource;
use App\Models\CapabilityRequirementMatch;
use App\Notifications\MatchResponseNotification;
use App\Traits\ApiResponse;
use App\Traits\Filterable;
use App\Services\RequirementMatchService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class CapabilityMatchController extends Controller
{
    use Filterable;
    use ApiResponse;
    private string $source;
    private string $routeName;

    public function __construct(private RequirementMatchService $requirementMatchService)
    {
        $this->source = 'Shared/Matches/Capabilities/Pages/';
        $this->routeName = 'capabilities.matches.';

        $this->middleware("permission:{$this->routeName}index")->only(['index']);
        $this->middleware("permission:{$this->routeName}store")->only(['accept', 'reject']);
        $this->authorizeResource(CapabilityRequirementMatch::class, 'capabilityRequirementMatch');
    }

    public function index(Request $request): Response
    {
        $filters = $this->getFiltersBase($request->query());

        $relations = [
            'requirement.user.academic.department.institution',
            'requirement.user.company',
            'requirement.user.institution',
            'requirement.user.governmentAgency',
            'requirement.user.nonProfitOrganization',
            'capability',
            'matchStatus',
            'offererEvaluation.matchEvaluationStatus'
        ];

        $query = $this->requirementMatchService->queryCapability($filters, $relations);
        $query = $this->requirementMatchService->buildFilters($query, $filters);

        $query->getCollection()->each(function ($match) {
            $match->requirement?->loadAndMountEntity();
        });

        return Inertia::render("{$this->source}Index", [
            'matches'       => CapabilityRequirementMatchResource::collection($query),
            'title'         => 'Vinculación de capacidades tecnológicas',
            'routeName'     => $this->routeName,
            'filters'       => $filters
        ]);
    }

    public function match(CapabilityRequirementMatch $capabilityRequirementMatch)
    {
        try {
            $capabilityRequirementMatch->load([
                'requirement.photos',
                'requirement.keywords',
                'requirement.department',
                'requirement.intellectualProperty',
                'requirement.technologyLevel',
                'requirement.oecdSectors',
                'requirement.economicSectors',
            ]);

            $capabilityRequirementMatch->requirement->loadAndMountEntity();
            return $this->success(new CapabilityRequirementMatchResource($capabilityRequirementMatch));
        } catch (Exception $e) {
            Log::error($e->getMessage(), [$e]);
            return $this->error('Ocurrió un error al consultar la necesidad');
        }
    }

    public function accept(CapabilityRequirementMatch $capabilityRequirementMatch)
    {
        $this->authorize('matchCapability', $capabilityRequirementMatch);
        try {
            $this->requirementMatchService->accept($capabilityRequirementMatch);
            $capabilityRequirementMatch->requirement->user->notify(
                new MatchResponseNotification($capabilityRequirementMatch, $capabilityRequirementMatch->capability)
            );
            return back()->with('success', 'Vinculación evaluada con éxito');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return back()->with('error', 'Ha ocurrido un error al evaluar la vinculación');
        }
    }

    public function reject(CapabilityRequirementMatch $capabilityRequirementMatch)
    {
        $this->authorize('matchCapability', $capabilityRequirementMatch);
        try {
            $this->requirementMatchService->reject($capabilityRequirementMatch);
            $capabilityRequirementMatch->requirement->user->notify(
                new MatchResponseNotification($capabilityRequirementMatch, $capabilityRequirementMatch->capability)
            );
            return back()->with('success', 'Vinculación evaluada con éxito');
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return back()->with('error', 'Ha ocurrido un error al evaluar la vinculación');
        }
    }
}
