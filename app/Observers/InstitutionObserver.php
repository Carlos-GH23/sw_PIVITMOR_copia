<?php

namespace App\Observers;

use App\Models\Institution\Institution;
use App\Models\Capability;
use App\Models\Company\JobOffer;
use App\Models\Institution\Facility;
use App\Models\Requirement;
use App\Models\TechnologyService;
use App\Models\Academic;
use App\Models\AcademicGroups\AcademicBody;
use App\Models\AcademicGroups\ResearchLine;
use App\Models\AcademicOfferings\AcademicOffering;
use App\Models\Conference;
use App\Models\Institution\FacilityEquipment;
use App\Models\Institution\InstitutionCertification;

class InstitutionObserver
{
    /**
     * Handle the Institution "created" event.
     */
    public function created(Institution $institution): void
    {
        //
    }

    /**
     * Handle the Institution "updated" event.
     */
    public function updated(Institution $institution): void
    {
        Academic::whereHas('department', function ($query) use ($institution) {
            $query->where('institution_id', $institution->id);
        })->searchable();

        Capability::whereHas('user.academic.department', function ($query) use ($institution) {
            $query->where('institution_id', $institution->id);
        })->searchable();

        Facility::whereHas('department', function ($query) use ($institution) {
            $query->where('institution_id', $institution->id);
        })->searchable();

        FacilityEquipment::whereHas('facility.department', function ($query) use ($institution) {
            $query->where('institution_id', $institution->id);
        })->searchable();

        Requirement::whereHas('user.academic.department', function ($query) use ($institution) {
            $query->where('institution_id', $institution->id);
        })->searchable();

        TechnologyService::whereHas('user.academic.department', function ($query) use ($institution) {
            $query->where('institution_id', $institution->id);
        })->searchable();

        AcademicOffering::whereHas('department', function ($query) use ($institution) {
            $query->where('institution_id', $institution->id);
        })->searchable();

        ResearchLine::whereHas('department', function ($query) use ($institution) {
            $query->where('institution_id', $institution->id);
        })->searchable();

        Conference::whereHas('department', function ($query) use ($institution) {
            $query->where('institution_id', $institution->id);
        })->searchable();

        InstitutionCertification::whereHas('department', function ($query) use ($institution) {
            $query->where('institution_id', $institution->id);
        })->searchable();

        AcademicBody::whereHas('department', function ($query) use ($institution) {
            $query->where('institution_id', $institution->id);
        })->searchable();
    }

    /**
     * Handle the Institution "deleted" event.
     */
    public function deleted(Institution $institution): void
    {
        //
    }

    /**
     * Handle the Institution "restored" event.
     */
    public function restored(Institution $institution): void
    {
        //
    }

    /**
     * Handle the Institution "force deleted" event.
     */
    public function forceDeleted(Institution $institution): void
    {
        //
    }
}
