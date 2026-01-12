<?php

namespace App\Http\Controllers;

use App\Traits\Filterable;
use Inertia\Inertia;
use App\Models\Institution\Institution;
use App\Models\Company\Company;
use App\Models\Academic;
use App\Models\AcademicGroups\ResearchLine;
use App\Models\Capability;
use App\Models\Requirement;
use App\Models\TechnologyService;
use App\Models\CapabilityRequirementMatch;
use App\Models\Company\TechnologyCompany;
use App\Models\Catalogs\OecdSector;
use App\Models\Catalogs\EconomicSector;

class EcosystemMapController extends Controller
{
    use Filterable;
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
        $this->routeName = 'welcome.ecosystemMap';
        $this->source = 'Interface/Welcome/Pages/';
    }

    public function index()
    {
        $ecosystemStats = $this->getEcosystemStats();
        $ecosystemResources = $this->getEcosystemResources();
        $oecdSectors = OecdSector::getHierarchy();
        $economicSectors = EconomicSector::getHierarchy();

        return Inertia::render("{$this->source}EcosystemMap", [
            'title' => 'Mapa ecosistema',
            'routeName' => $this->routeName,
            'source' => $this->source,
            'ecosystemStats' => $ecosystemStats,
            'ecosystemResources' => $ecosystemResources,
            'oecdSectors' => $oecdSectors,
            'economicSectors' => $economicSectors,
        ]);
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

        return $uniqueResources->map(function ($hit) {
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
                'oecd_sector_ids' => $hit['oecd_sector_ids'] ?? [],
                'economic_sector_ids' => $hit['economic_sector_ids'] ?? [],
            ];
        });
    }
}
