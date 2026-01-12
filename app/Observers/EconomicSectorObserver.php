<?php

namespace App\Observers;

use App\Models\Academic;
use App\Models\AcademicGroups\AcademicBody;
use App\Models\AcademicGroups\ResearchLine;
use App\Models\AcademicOfferings\AcademicOffering;
use App\Models\Capability;
use App\Models\Catalogs\EconomicSector;
use App\Models\Company\Company;
use App\Models\Company\JobOffer;
use App\Models\Conference;
use App\Models\Institution\Institution;
use App\Models\NonProfitOrganization;
use App\Models\Requirement;
use App\Models\TechnologyService;

class EconomicSectorObserver
{
    /**
     * Handle the EconomicSector "created" event.
     */
    public function created(EconomicSector $economicSector): void
    {
        //
    }

    /**
     * Handle the EconomicSector "updated" event.
     */
    public function updated(EconomicSector $economicSector): void
    {
        Academic::whereHas('economicSectors', function ($query) use ($economicSector) {
            $query->where('economic_sectors.id', $economicSector->id);
        })->searchable();

        Capability::whereHas('economicSectors', function ($query) use ($economicSector) {
            $query->where('economic_sectors.id', $economicSector->id);
        })->searchable();

        TechnologyService::whereHas('economicSectors', function ($query) use ($economicSector) {
            $query->where('economic_sectors.id', $economicSector->id);
        })->searchable();

        Requirement::whereHas('economicSectors', function ($query) use ($economicSector) {
            $query->where('economic_sectors.id', $economicSector->id);
        })->searchable();

        Conference::whereHas('economicSectors', function ($query) use ($economicSector) {
            $query->where('economic_sectors.id', $economicSector->id);
        })->searchable();

        AcademicBody::whereHas('economicSectors', function ($query) use ($economicSector) {
            $query->where('economic_sectors.id', $economicSector->id);
        })->searchable();

        ResearchLine::whereHas('economicSectors', function ($query) use ($economicSector) {
            $query->where('economic_sectors.id', $economicSector->id);
        })->searchable();

        AcademicOffering::whereHas('economicSectors', function ($query) use ($economicSector) {
            $query->where('economic_sectors.id', $economicSector->id);
        })->searchable();

        Institution::whereHas('economicSectors', function ($query) use ($economicSector) {
            $query->where('economic_sectors.id', $economicSector->id);
        })->searchable();

        Company::whereHas('technologyCompany.economicSectors', function ($query) use ($economicSector) {
            $query->where('economic_sectors.id', $economicSector->id);
        })->searchable();

        JobOffer::whereHas('economicSectors', function ($query) use ($economicSector) {
            $query->where('economic_sectors.id', $economicSector->id);
        })->searchable();

        NonProfitOrganization::where('economic_sector_id', $economicSector->id)->searchable();
    }

    /**
     * Handle the EconomicSector "deleted" event.
     */
    public function deleted(EconomicSector $economicSector): void
    {
        //
    }

    /**
     * Handle the EconomicSector "restored" event.
     */
    public function restored(EconomicSector $economicSector): void
    {
        //
    }

    /**
     * Handle the EconomicSector "force deleted" event.
     */
    public function forceDeleted(EconomicSector $economicSector): void
    {
        //
    }
}
