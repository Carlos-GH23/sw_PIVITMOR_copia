<?php

namespace App\Observers;

use App\Models\Institution\InstitutionCategory;
use App\Models\Academic;
use App\Models\AcademicGroups\AcademicBody;
use App\Models\AcademicGroups\ResearchLine;
use App\Models\AcademicOfferings\AcademicOffering;
use App\Models\Capability;
use App\Models\Conference;
use App\Models\Institution\Facility;
use App\Models\Institution\FacilityEquipment;
use App\Models\Institution\InstitutionCertification;
use App\Models\TechnologyService;
use App\Models\Institution\Institution;

class InstitutionCategoryObserver
{
    /**
     * Handle the InstitutionCategory "created" event.
     */
    public function created(InstitutionCategory $institutionCategory): void
    {
        //
    }

    /**
     * Handle the InstitutionCategory "updated" event.
     */
    public function updated(InstitutionCategory $institutionCategory): void
    {
        Institution::whereHas('institutionType', function ($query) use ($institutionCategory) {
            $query->where('institution_category_id', $institutionCategory->id);
        })->searchable();

        Academic::whereHas('department.institution.institutionType', function ($query) use ($institutionCategory) {
            $query->where('institution_category_id', $institutionCategory->id);
        })->searchable();

        Facility::whereHas('department.institution.institutionType', function ($query) use ($institutionCategory) {
            $query->where('institution_category_id', $institutionCategory->id);
        })->searchable();

        Capability::whereHas('user.academic.department.institution.institutionType', function ($query) use ($institutionCategory) {
            $query->where('institution_category_id', $institutionCategory->id);
        })->searchable();

        TechnologyService::whereHas('user.academic.department.institution.institutionType', function ($query) use ($institutionCategory) {
            $query->where('institution_category_id', $institutionCategory->id);
        })->searchable();

        FacilityEquipment::whereHas('facility.department.institution.institutionType', function ($query) use ($institutionCategory) {
            $query->where('institution_category_id', $institutionCategory->id);
        })->searchable();

        InstitutionCertification::whereHas('department.institution.institutionType', function ($query) use ($institutionCategory) {
            $query->where('institution_category_id', $institutionCategory->id);
        })->searchable();

        AcademicBody::whereHas('department.institution.institutionType', function ($query) use ($institutionCategory) {
            $query->where('institution_category_id', $institutionCategory->id);
        })->searchable();

        ResearchLine::whereHas('department.institution.institutionType', function ($query) use ($institutionCategory) {
            $query->where('institution_category_id', $institutionCategory->id);
        })->searchable();

        AcademicOffering::whereHas('department.institution.institutionType', function ($query) use ($institutionCategory) {
            $query->where('institution_category_id', $institutionCategory->id);
        })->searchable();

        Conference::whereHas('department.institution.institutionType', function ($query) use ($institutionCategory) {
            $query->where('institution_category_id', $institutionCategory->id);
        })->searchable();
    }

    /**
     * Handle the InstitutionCategory "deleted" event.
     */
    public function deleted(InstitutionCategory $institutionCategory): void
    {
        //
    }

    /**
     * Handle the InstitutionCategory "restored" event.
     */
    public function restored(InstitutionCategory $institutionCategory): void
    {
        //
    }

    /**
     * Handle the InstitutionCategory "force deleted" event.
     */
    public function forceDeleted(InstitutionCategory $institutionCategory): void
    {
        //
    }
}
