<?php

namespace App\Providers;

use App\Models\AcademicGroups\AcademicBody;
use App\Models\AcademicGroups\ResearchLine;
use App\Policies\AcademicPolicy;
use App\Models\Conference;
use App\Models\Institution\Department;
use App\Models\Requirement;
use App\Models\Academic;
use App\Models\AcademicOfferings\AcademicOffering;
use App\Models\Capability;
use App\Policies\AcademicBodyPolicy;
use App\Policies\ConferencePolicy;
use App\Policies\RequirementPolicy;
use App\Policies\ResearchLinePolicy;
use App\Policies\FacilityPolicy;
use App\Models\Institution\Facility;
use App\Policies\FacilityEquipmentPolicy;
use App\Models\Institution\FacilityEquipment;
use App\Policies\DepartmentPolicy;
use App\Policies\InstitutionCertificationPolicy;
use App\Models\Institution\InstitutionCertification;
use App\Models\TechnologyService;
use App\Policies\TechnologyServicePolicy;
use App\Policies\AcademicOfferingPolicy;
use App\Policies\CapabilityEvaluationPolicy;
use App\Models\Academic\AcademicBackground;
use App\Policies\AcademicBackgroundPolicy;
use App\Policies\TechnologyServiceEvaluationPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'CapabilityEvaluation' => CapabilityEvaluationPolicy::class,
        Requirement::class => RequirementPolicy::class,
        Conference::class => ConferencePolicy::class,
        Facility::class => FacilityPolicy::class,
        FacilityEquipment::class => FacilityEquipmentPolicy::class,
        Department::class => DepartmentPolicy::class,
        InstitutionCertification::class => InstitutionCertificationPolicy::class,
        Academic::class=> AcademicPolicy::class,
        AcademicBody::class => AcademicBodyPolicy::class,
        ResearchLine::class => ResearchLinePolicy::class,
        TechnologyService::class => TechnologyServicePolicy::class,
        AcademicOffering::class => AcademicOfferingPolicy::class,
        AcademicBackground::class => AcademicBackgroundPolicy::class,
        'TechnologyServiceEvaluation'::class => TechnologyServiceEvaluationPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        /* Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        }); */
        // Gate::before(function ($user, $ability) {
        //     return $user->hasRole('Admin') ? true : null;
        // });
    }
}
