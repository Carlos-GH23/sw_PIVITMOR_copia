<?php

namespace App\Providers;

use App\Models\Academic;
use App\Models\AcademicGroups\AcademicBody;
use App\Models\AcademicGroups\ResearchLine;
use App\Models\Catalogs\EconomicSector;
use App\Models\Catalogs\InstitutionType;
use App\Models\Catalogs\OecdSector;
use App\Models\Company\Company;
use App\Models\GovernmentAgency\GovernmentAgency;
use App\Models\Institution\Department;
use App\Models\Institution\Facility;
use App\Models\Institution\Institution;
use App\Models\Institution\InstitutionCategory;
use App\Models\Location;
use App\Models\NonProfitOrganization;
use App\Observers\AcademicBodyObserver;
use App\Observers\AcademicObserver;
use App\Observers\CompanyObserver;
use App\Observers\DepartmentObserver;
use App\Observers\EconomicSectorObserver;
use App\Observers\FacilityObserver;
use App\Observers\GovernmentAgencyObserver;
use App\Observers\InstitutionCategoryObserver;
use App\Observers\InstitutionObserver;
use App\Observers\InstitutionTypeObserver;
use App\Observers\LocationObserver;
use App\Observers\NonProfitOrganizationObserver;
use App\Observers\OecdSectorObserver;
use App\Observers\ResearchLineObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        InstitutionCategory::observe(InstitutionCategoryObserver::class);
        InstitutionType::observe(InstitutionTypeObserver::class);
        Institution::observe(InstitutionObserver::class);
        Department::observe(DepartmentObserver::class);

        Location::observe(LocationObserver::class);

        Academic::observe(AcademicObserver::class);
        AcademicBody::observe(AcademicBodyObserver::class);
        ResearchLine::observe(ResearchLineObserver::class);

        Facility::observe(FacilityObserver::class);

        OecdSector::observe(OecdSectorObserver::class);
        EconomicSector::observe(EconomicSectorObserver::class);

        Company::observe(CompanyObserver::class);
        GovernmentAgency::observe(GovernmentAgencyObserver::class);
        NonProfitOrganization::observe(NonProfitOrganizationObserver::class);
    }
}
