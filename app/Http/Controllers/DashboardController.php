<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\AcademicGroups\ResearchLine;
use App\Models\Institution\Facility;
use App\Models\Academic;
use App\Models\TechnologyService;
use App\Models\Capability;
use App\Models\Institution\FacilityEquipment;
use App\Models\Requirement;
use App\Models\AcademicOfferings\AcademicOffering;
use App\Models\CapabilityRequirementMatch;
use App\Models\Catalogs\IntellectualProperty;
use App\Models\Company\Company;
use App\Models\GovernmentAgency\GovernmentAgency;
use App\Models\Institution\Institution;
use App\Models\Institution\InstitutionCertification;
use App\Models\NonProfitOrganization;
use App\Services\OpportunityService;
use App\Traits\Filterable;
use Inertia\Inertia;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use Filterable;
    private string $source;
    private OpportunityService $opportunityService;
    private string $routeName;

    public function __construct(OpportunityService $opportunityService)
    {
        $this->source    = "Interface/Dashboard/";
        $this->middleware('auth');
        $this->routeName = "dashboard";

        $this->opportunityService = $opportunityService;
    }

    public function dashboard(Request $request)
    {
        $user = $request->user();

        if ($user->can('dashboard.opportunities')) {
            return $this->opportunityDashboard($request);
        }

        if ($user->canAny(['dashboard.institutionIndicators', 'dashboard.institutionIndicatorsAdmin'])) {
            $data = $user->can('dashboard.institutionIndicatorsAdmin')
                ? $this->getInstitutionDashboardDataAdmin($user)
                : $this->getInstitutionDashboardData($user);

            return Inertia::render("{$this->source}General/Pages/Index", array_merge([
                'title' => 'Panel de Indicadores',
                'description' => 'Métricas clave de nuestra institución tecnológica',
            ], $data));
        }
    }

    public function opportunityDashboard(Request $request)
    {
        $filters = $this->getOpportunityFilters($request->query());
        $opportunities = $this->opportunityService->performUnifiedSearch($filters, $request);

        return Inertia::render("{$this->source}Opportunity/Pages/Index", [
            'title' => 'Oportunidades',
            'routeName' => $this->routeName,
            'description' => 'Explora las oportunidades disponibles en nuestra plataforma',
            'intellectualProperties' => IntellectualProperty::select('id', 'name')->orderBy('name')->get(),
            'filters' => $filters,
            'opportunities' => $opportunities,
        ]);
    }


    public function getInstitutionDashboardData($user)
    {
        $institution = $user->institution;

        if (!$institution) {
            return [
                'kpis' => $this->getEmptyKpis(),
                'institution' => [
                    'name' => 'Sin perfil de institución',
                    'logo' => null,
                ],
            ];
        }

        $departments = $institution->departments();
        $departmentIds = $departments ? $departments->pluck('id') : collect([]);

        if ($departmentIds->isEmpty()) {
            return [
                'kpis' => $this->getEmptyKpis(),
                'institution' => [
                    'logo' => $institution->logo ? $institution->logo->url : null,
                ],
            ];
        }

        $requirementIds = Requirement::whereIn('department_id', $departmentIds)->where('is_active', 1)->pluck('id');
        $capabilityIds = Capability::whereIn('department_id', $departmentIds)->where('is_active', 1)->pluck('id');

        $vinculationsCount = CapabilityRequirementMatch::whereIn('requirement_id', $requirementIds)
            ->whereIn('capability_id', $capabilityIds)
            ->where('is_active', 1)
            ->count();

        $kpis = [
            'departments' => $institution->departments()->where('is_active', 1)->count(),
            'institution_certifications' => InstitutionCertification::whereIn('department_id', $departmentIds)->where('is_active', 1)->count(),
            'facility_equipment' => FacilityEquipment::whereIn('department_id', $departmentIds)->where('status', 1)->count(),
            'conferences' => Conference::whereIn('department_id', $departmentIds)->where('conference_status_id', 2)->count(),
            'facilities' => Facility::whereIn('department_id', $departmentIds)->where('is_active', 1)->count(),
            'academics' => Academic::whereIn('department_id', $departmentIds)->where('is_active', 1)->count(),
            'academics_with_snii' => Academic::whereIn('department_id', $departmentIds)->where('is_active', 1)->whereHas('sniMembership')->count(),
            'academic_offerings' => AcademicOffering::whereIn('department_id', $departmentIds)->where('is_active', 1)->count(),
            'technology_services' => TechnologyService::whereIn('department_id', $departmentIds)->where('is_active', 1)->where('technology_service_status_id', 3)->count(),
            'capabilities' => Capability::whereIn('department_id', $departmentIds)->where('is_active', 1)->where('capability_status_id', 3)->count(),
            'requirements' => Requirement::whereIn('department_id', $departmentIds)->where('is_active', 1)->where('requirement_status_id', 3)->count(),
            'vinculations' => $vinculationsCount,
        ];

        $institutionData = [
            'name' => $institution->name ?? 'Sin perfil de institución',
            'logo' => $institution->logo ? $institution->logo->url : null,
        ];

        return [
            'kpis' => $kpis,
            'institution' => $institutionData,
        ];
    }

    private function getEmptyKpis()
    {
        return [
            'departments' => 0,
            'institution_certifications' => 0,
            'facility_equipment' => 0,
            'conferences' => 0,
            'research_lines' => 0,
            'facilities' => 0,
            'academics' => 0,
            'academics_with_snii' => 0,
            'academic_offerings' => 0,
            'technology_services' => 0,
            'capabilities' => 0,
            'requirements' => 0,
            'vinculations' => 0,
        ];
    }

    public function getInstitutionDashboardDataAdmin($user)
    {
        $vinculationsCount = CapabilityRequirementMatch::where('is_active', 1)->count();

        $kpis = [
            'ies' => Institution::whereHas('institutionType', function ($query) {
                $query->where('institution_category_id', 1);
            })->count(),
            'ci' => Institution::whereHas('institutionType', function ($query) {
                $query->where('institution_category_id', 2);
            })->count(),
            'ebt' => Company::where('is_active', 1)->count(),
            'ong' => NonProfitOrganization::where('is_active', 1)->count(),
            'government' => GovernmentAgency::where('is_active', 1)->count(),
            'institution_certifications' => InstitutionCertification::where('is_active', 1)->count(),
            'facility_equipment' => FacilityEquipment::where('status', 1)->count(),
            'conferences' => Conference::where('conference_status_id', 2)->count(),
            'facilities' => Facility::where('is_active', 1)->count(),
            'academics' => Academic::where('is_active', 1)->count(),
            'academics_with_snii' => Academic::where('is_active', 1)->whereHas('sniMembership')->count(),
            'academic_offerings' => AcademicOffering::where('is_active', 1)->count(),
            'technology_services' => TechnologyService::where('is_active', 1)->where('technology_service_status_id', 3)->count(),
            'capabilities' => Capability::where('is_active', 1)->where('capability_status_id', 3)->count(),
            'requirements' => Requirement::where('is_active', 1)->where('requirement_status_id', 3)->count(),
            'vinculations' => $vinculationsCount,
        ];

        return [
            'kpis' => $kpis,
        ];
    }
}
