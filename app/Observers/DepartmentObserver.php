<?php

namespace App\Observers;

use App\Models\Academic;
use App\Models\AcademicGroups\AcademicBody;
use App\Models\AcademicGroups\ResearchLine;
use App\Models\AcademicOfferings\AcademicOffering;
use App\Models\Capability;
use App\Models\Conference;
use App\Models\Institution\Department;
use App\Models\Institution\Facility;
use App\Models\Institution\FacilityEquipment;
use App\Models\Institution\InstitutionCertification;
use App\Models\Requirement;
use App\Models\TechnologyService;

class DepartmentObserver
{
    /**
     * Handle the Department "created" event.
     */
    public function created(Department $department): void
    {
        //
    }

    /**
     * Handle the Department "updated" event.
     */
    public function updated(Department $department): void
    {
        Academic::where('department_id', $department->id)->searchable();

        Capability::whereHas('user.academic', function ($query) use ($department) {
            $query->where('department_id', $department->id);
        })->searchable();

        TechnologyService::where('department_id', $department->id)
            ->orWhereHas('user.academic', function ($query) use ($department) {
                $query->where('department_id', $department->id);
            })->searchable();

        Requirement::where('department_id', $department->id)
            ->orWhereHas('user.academic', function ($query) use ($department) {
                $query->where('department_id', $department->id);
            })->searchable();

        Conference::where('department_id', $department->id)->searchable();
        Facility::where('department_id', $department->id)->searchable();

        FacilityEquipment::where('department_id', $department->id)
            ->orWhereHas('facility', function ($query) use ($department) {
                $query->where('department_id', $department->id);
            })->searchable();

        InstitutionCertification::where('department_id', $department->id)->searchable();
        AcademicBody::where('department_id', $department->id)->searchable();
        ResearchLine::where('department_id', $department->id)->searchable();
        AcademicOffering::where('department_id', $department->id)->searchable();
    }

    /**
     * Handle the Department "deleted" event.
     */
    public function deleted(Department $department): void
    {
        //
    }

    /**
     * Handle the Department "restored" event.
     */
    public function restored(Department $department): void
    {
        //
    }

    /**
     * Handle the Department "force deleted" event.
     */
    public function forceDeleted(Department $department): void
    {
        //
    }
}
