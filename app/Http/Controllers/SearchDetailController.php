<?php

namespace App\Http\Controllers;

use App\Http\Resources\AcademicBodyResource;
use App\Http\Resources\CapabilityResource;
use App\Http\Resources\Company\CompanyResource;
use App\Http\Resources\Company\JobOfferResource;
use App\Http\Resources\ConferenceResource;
use App\Http\Resources\GovernmentAgency\GovernmentAgencyResource;
use App\Http\Resources\Institution\AcademicOfferingResource;
use App\Http\Resources\Institution\AcademicResource;
use App\Http\Resources\Institution\CertificationResource;
use App\Http\Resources\Institution\FacilityEquipmentResource;
use App\Http\Resources\Institution\FacilityResource;
use App\Http\Resources\Institution\InstitutionResource;
use App\Http\Resources\NonProfitOrganizationResource;
use App\Http\Resources\RequirementResource;
use App\Http\Resources\ResearchLineResource;
use App\Http\Resources\TechnologyServiceResource;
use App\Models\Academic;
use App\Models\AcademicGroups\AcademicBody;
use App\Models\AcademicGroups\ResearchLine;
use App\Models\AcademicOfferings\AcademicOffering;
use App\Models\Capability;
use App\Models\Company\Company;
use App\Models\Company\JobOffer;
use App\Models\Conference;
use App\Models\GovernmentAgency\GovernmentAgency;
use App\Models\Institution\Facility;
use App\Models\Institution\FacilityEquipment;
use App\Models\Institution\Institution;
use App\Models\Institution\InstitutionCertification;
use App\Models\NonProfitOrganization;
use App\Models\Requirement;
use App\Models\TechnologyService;
use App\Services\ViewTrackingService;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Log;

class SearchDetailController extends Controller
{
    use ApiResponse;

    public function __construct(protected ViewTrackingService $viewTrackingService) {}

    private const RESOURCE_MAP = [
        'capability'                => [Capability::class, CapabilityResource::class],
        'requirement'               => [Requirement::class, RequirementResource::class],
        'academic'                  => [Academic::class, AcademicResource::class],
        'facility'                  => [Facility::class, FacilityResource::class],
        'equipment'                 => [FacilityEquipment::class, FacilityEquipmentResource::class],
        'institution_certification' => [InstitutionCertification::class, CertificationResource::class],
        'technology_service'        => [TechnologyService::class, TechnologyServiceResource::class],
        'research_line'             => [ResearchLine::class, ResearchLineResource::class],
        'academic_body'             => [AcademicBody::class, AcademicBodyResource::class],
        'conference'                => [Conference::class, ConferenceResource::class],
        'job_offer'                 => [JobOffer::class, JobOfferResource::class],
        'academic_offering'         => [AcademicOffering::class, AcademicOfferingResource::class],
        'higher_education'          => [Institution::class, InstitutionResource::class],
        'research_center'           => [Institution::class, InstitutionResource::class],
        'company'                   => [Company::class, CompanyResource::class],
        'government_agency'         => [GovernmentAgency::class, GovernmentAgencyResource::class],
        'non_profit'                => [NonProfitOrganization::class, NonProfitOrganizationResource::class],
    ];
    /**
     * Handle the incoming request.
     */
    public function __invoke(String $type, int $id)
    {
        if (!array_key_exists($type, self::RESOURCE_MAP)) {
            return $this->error('No se encontro el recurso');
        }

        [$modelClass, $resourceClass] = self::RESOURCE_MAP[$type];
        $record = $modelClass::withSearchDetails()->findOrFail($id);
        $this->viewTrackingService->recordView($record);

        if ($record->location !== null) {
            $record->location->append('full_address');
        }

        if (method_exists($record, 'loadAndMountEntity')) {
            $record->loadAndMountEntity();
        }

        return $this->success(new $resourceClass($record));
    }
}
