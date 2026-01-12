<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrganizationRegistrationRequest;
use App\Models\Municipality;
use App\Models\State;
use App\Models\OrganizationRegistration;
use App\Models\OrganizationRegistrationStatus;
use App\Models\Capability;
use App\Models\Institution\Institution;
use App\Models\Company\Company;
use App\Models\Academic;
use App\Models\AcademicGroups\ResearchLine;
use App\Models\Requirement;
use App\Models\TechnologyService;
use App\Models\CapabilityRequirementMatch;
use App\Models\Company\TechnologyCompany;
use App\Enums\OrganizationType;
use App\Http\Resources\SuccessStoryResource;
use App\Models\MatchEvaluation;
use Exception;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class WelcomeController extends Controller
{
    protected string $routeName;
    protected string $source;
    private const ECOSYSTEM_RESOURCE_TYPES = [
        'higher_education',
        'research_center',
        'company',
        'non_profit',
        'capability',
        'technology_service',
        'academic_offering',
    ];

    public function __construct()
    {
        $this->routeName = "welcome.";
        $this->source    = "Interface/Welcome/Pages/";
    }

    public function home()
    {
        $successStories = MatchEvaluation::query()->with(['categories'])
            ->where('is_success_story', true)->orderBy('rating', 'desc')
            ->take(2)->get();

        return Inertia::render("{$this->source}Home", [
            'states' => State::orderBy('name')->select('id', 'name')->get(),
            'municipalities' => Municipality::orderBy('name')->select('id', 'name', 'state_id')->get(),
            'organizationTypes' => OrganizationType::toSelectArray(),
            'ecosystemResources' => $this->getEcosystemResources(),
            'ecosystemStats' => $this->getEcosystemStats(),
            'successStories' => SuccessStoryResource::collection($successStories),
        ]);
    }

    public function create()
    {
        return Inertia::render("{$this->source}Home", [
            'states' => State::orderBy('name')->select('id', 'name')->get(),
            'municipalities' => Municipality::orderBy('name')->select('id', 'name', 'state_id')->get(),
            'organizationTypes' => OrganizationType::toSelectArray(),
        ]);
    }

    public function store(StoreOrganizationRegistrationRequest $request)
    {
        try {
            $data = $request->validated();
            $pendingStatus = OrganizationRegistrationStatus::where('name', 'Pendiente')->first();
            $data['organization_registration_status_id'] = $pendingStatus->id;

            OrganizationRegistration::create($data);
            return redirect()->back();
        } catch (Exception $exception) {
            Log::error($exception->getMessage(), [$exception]);
            return redirect()->back()->withErrors(['error' => 'Ha ocurrido un error al crear el registro']);
        }
    }

    private function getEcosystemResources()
    {
        $search = Academic::search('*')
            ->whereIn('resource_type', self::ECOSYSTEM_RESOURCE_TYPES);

        $results = $search->options(['limit' => 10000])->raw();

        if (empty($results['hits'])) {
            return [];
        }

        $uniqueResources = collect($results['hits'])->unique(function ($hit) {
            return $hit['resource_type'] . '_' . $hit['model_id'];
        });

        return $uniqueResources
            ->map(function ($hit) {
                return [
                    'id' => $hit['model_id'],
                    'type' => $hit['resource_type'] ?? 'unknown',
                    'title' => $hit['title'] ?? $hit['institution_name'] ?? $hit['name'] ?? '',
                    'description' => $hit['description'] ?? '',
                    'latitude' => $hit['latitude'] ?? null,
                    'longitude' => $hit['longitude'] ?? null,
                    'institution' => $hit['institution_name'] ?? $hit['company'] ?? $hit['legal_name'] ?? '',
                    'institution_category' => $hit['institution_category'] ?? null,
                    'institution_code' => $hit['institution_code'] ?? null,
                ];
            })
            ->values();
    }

    private function getEcosystemStats()
    {
        return [
            'ies' => Institution::whereHas('institutionType', function ($query) {
                $query->where('institution_category_id', 1);
            })->count(),
            'ci' => Institution::whereHas('institutionType', function ($query) {
                $query->where('institution_category_id', 2);
            })->count(),
            'companies' => Company::where('is_active', 1)->count(),
            'academics' => Academic::where('is_active', 1)->count(),
            'tech_companies' => TechnologyCompany::count(),
            'requirements' => Requirement::where('is_active', 1)->where('requirement_status_id', 3)->count(),
            'capabilities' => Capability::where('is_active', 1)->where('capability_status_id', 3)->count(),
            'technology_services' => TechnologyService::where('is_active', 1)->where('technology_service_status_id', 3)->count(),
            'collaborations' => CapabilityRequirementMatch::where('is_active', 1)->count(),
        ];
    }
}
