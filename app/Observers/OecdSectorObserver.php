<?php

namespace App\Observers;

use App\Models\AcademicGroups\AcademicBody;
use App\Models\AcademicGroups\ResearchLine;
use App\Models\AcademicOfferings\AcademicOffering;
use App\Models\Capability;
use App\Models\Catalogs\OecdSector;
use App\Models\Company\Company;
use App\Models\Company\JobOffer;
use App\Models\Conference;
use App\Models\Institution\Institution;
use App\Models\Requirement;
use App\Models\TechnologyService;

class OecdSectorObserver
{
    /**
     * Handle the OecdSector "created" event.
     */
    public function created(OecdSector $oecdSector): void
    {
        //
    }

    /**
     * Handle the OecdSector "updated" event.
     */
    public function updated(OecdSector $oecdSector): void
    {
        Capability::whereHas('oecdSectors', function ($query) use ($oecdSector) {
            $query->where('oecd_sectors.id', $oecdSector->id);
        })->searchable();

        TechnologyService::whereHas('oecdSectors', function ($query) use ($oecdSector) {
            $query->where('oecd_sectors.id', $oecdSector->id);
        })->searchable();

        Requirement::whereHas('oecdSectors', function ($query) use ($oecdSector) {
            $query->where('oecd_sectors.id', $oecdSector->id);
        })->searchable();

        Conference::whereHas('oecdSectors', function ($query) use ($oecdSector) {
            $query->where('oecd_sectors.id', $oecdSector->id);
        })->searchable();

        AcademicBody::whereHas('oecdSectors', function ($query) use ($oecdSector) {
            $query->where('oecd_sectors.id', $oecdSector->id);
        })->searchable();

        ResearchLine::whereHas('oecdSectors', function ($query) use ($oecdSector) {
            $query->where('oecd_sectors.id', $oecdSector->id);
        })->searchable();

        AcademicOffering::whereHas('oecdSectors', function ($query) use ($oecdSector) {
            $query->where('oecd_sectors.id', $oecdSector->id);
        })->searchable();

        Institution::whereHas('oecdSectors', function ($query) use ($oecdSector) {
            $query->where('oecd_sectors.id', $oecdSector->id);
        })->searchable();

        Company::whereHas('technologyCompany.oecdSectors', function ($query) use ($oecdSector) {
            $query->where('oecd_sectors.id', $oecdSector->id);
        })->searchable();

        JobOffer::whereHas('oecdSectors', function ($query) use ($oecdSector) {
            $query->where('oecd_sectors.id', $oecdSector->id);
        })->searchable();
    }

    /**
     * Handle the OecdSector "deleted" event.
     */
    public function deleted(OecdSector $oecdSector): void
    {
        //
    }

    /**
     * Handle the OecdSector "restored" event.
     */
    public function restored(OecdSector $oecdSector): void
    {
        //
    }

    /**
     * Handle the OecdSector "force deleted" event.
     */
    public function forceDeleted(OecdSector $oecdSector): void
    {
        //
    }
}
