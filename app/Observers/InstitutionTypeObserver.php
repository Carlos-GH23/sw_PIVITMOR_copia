<?php

namespace App\Observers;

use App\Models\Catalogs\InstitutionType;
use App\Models\Institution\Institution;
use App\Models\Capability;
use App\Models\Institution\Facility;
use App\Models\TechnologyService;
use App\Models\Academic;
use App\Models\AcademicGroups\AcademicBody;
use App\Models\AcademicGroups\ResearchLine;
use App\Models\AcademicOfferings\AcademicOffering;
use App\Models\Conference;
use App\Models\Institution\FacilityEquipment;
use App\Models\Institution\InstitutionCertification;

class InstitutionTypeObserver
{
    /**
     * Handle the InstitutionType "created" event.
     */
    public function created(InstitutionType $institutionType): void
    {
        //
    }

    /**
     * Handle the InstitutionType "updated" event.
     */
    public function updated(InstitutionType $institutionType): void
    {
        Institution::where('institution_type_id', $institutionType->id)->searchable();

        Academic::whereHas('department.institution', function ($query) use ($institutionType) {
            $query->where('institution_type_id', $institutionType->id);
        })->searchable();

        Capability::whereHas('user.academic.department.institution', function ($query) use ($institutionType) {
            $query->where('institution_type_id', $institutionType->id);
        })->searchable();

        TechnologyService::whereHas('user.academic.department.institution', function ($query) use ($institutionType) {
            $query->where('institution_type_id', $institutionType->id);
        })->searchable();

        Conference::whereHas('department.institution', function ($query) use ($institutionType) {
            $query->where('institution_type_id', $institutionType->id);
        })->searchable();

        Facility::whereHas('department.institution', function ($query) use ($institutionType) {
            $query->where('institution_type_id', $institutionType->id);
        })->searchable();

        FacilityEquipment::whereHas('facility.department.institution', function ($query) use ($institutionType) {
            $query->where('institution_type_id', $institutionType->id);
        })->searchable();

        InstitutionCertification::whereHas('department.institution', function ($query) use ($institutionType) {
            $query->where('institution_type_id', $institutionType->id);
        })->searchable();

        AcademicBody::whereHas('department.institution', function ($query) use ($institutionType) {
            $query->where('institution_type_id', $institutionType->id);
        })->searchable();

        ResearchLine::whereHas('department.institution', function ($query) use ($institutionType) {
            $query->where('institution_type_id', $institutionType->id);
        })->searchable();

        AcademicOffering::whereHas('department.institution', function ($query) use ($institutionType) {
            $query->where('institution_type_id', $institutionType->id);
        })->searchable();
    }

    /**
     * Handle the InstitutionType "deleted" event.
     */
    public function deleted(InstitutionType $institutionType): void
    {
        //
    }

    /**
     * Handle the InstitutionType "restored" event.
     */
    public function restored(InstitutionType $institutionType): void
    {
        //
    }

    /**
     * Handle the InstitutionType "force deleted" event.
     */
    public function forceDeleted(InstitutionType $institutionType): void
    {
        //
    }
}
