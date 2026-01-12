<?php

namespace App\Observers;

use App\Models\Capability;
use App\Models\Location;
use App\Models\Requirement;
use App\Models\TechnologyService;
use App\Models\Academic;
use App\Models\AcademicGroups\AcademicBody;
use App\Models\AcademicGroups\ResearchLine;
use App\Models\AcademicOfferings\AcademicOffering;
use App\Models\Company\Company;
use App\Models\Company\JobOffer;
use App\Models\Conference;
use App\Models\GovernmentAgency\GovernmentAgency;
use App\Models\Institution\Facility;
use App\Models\Institution\FacilityEquipment;
use App\Models\Institution\Institution;
use App\Models\NonProfitOrganization;

class LocationObserver
{
    /**
     * Handle the Location "created" event.
     */
    public function created(Location $location): void
    {
        //
    }

    /**
     * Handle the Location "updated" event.
     */
    public function updated(Location $location): void
    {
        $locatable = $location->locationable;

        if ($locatable instanceof Institution) {
            $locatable->searchable();

            Capability::whereHas('user.academic.department.institution.location', function ($query) use ($location) {
                $query->where('id', $location->id);
            })->searchable();

            TechnologyService::whereHas('user.academic.department.institution.location', function ($query) use ($location) {
                $query->where('id', $location->id);
            })->searchable();

            Academic::whereHas('department.institution.location', function ($query) use ($location) {
                $query->where('id', $location->id);
            })->searchable();

            AcademicBody::whereHas('department.institution.location', function ($query) use ($location) {
                $query->where('id', $location->id);
            })->searchable();

            AcademicOffering::whereHas('department.institution.location', function ($query) use ($location) {
                $query->where('id', $location->id);
            })->searchable();

            ResearchLine::whereHas('department.institution.location', function ($query) use ($location) {
                $query->where('id', $location->id);
            })->searchable();

            Conference::whereHas('department.institution.location', function ($query) use ($location) {
                $query->where('id', $location->id);
            })->searchable();

            Facility::whereHas('department.institution.location', function ($query) use ($location) {
                $query->where('id', $location->id);
            })->searchable();

            FacilityEquipment::whereHas('facility.department.institution.location', function ($query) use ($location) {
                $query->where('id', $location->id);
            })->searchable();
        } elseif ($locatable instanceof Company) {
            $locatable->searchable();

            JobOffer::whereHas('user.company.location', function ($query) use ($location) {
                $query->where('id', $location->id);
            })->searchable();
        } elseif ($locatable instanceof GovernmentAgency) {
            $locatable->searchable();
        } elseif ($locatable instanceof NonProfitOrganization) {
            $locatable->searchable();
        }

        Requirement::whereHas('user', function ($query) use ($location) {
            $query->where(function ($q) use ($location) {
                $q->whereHas('academic.department.institution.location', function ($sub) use ($location) {
                    $sub->where('id', $location->id);
                })
                    ->orWhereHas('company.location', function ($sub) use ($location) {
                        $sub->where('id', $location->id);
                    })
                    ->orWhereHas('governmentAgency.location', function ($sub) use ($location) {
                        $sub->where('id', $location->id);
                    })
                    ->orWhereHas('nonProfitOrganization.location', function ($sub) use ($location) {
                        $sub->where('id', $location->id);
                    });
            });
        })->searchable();
    }

    /**
     * Handle the Location "deleted" event.
     */
    public function deleted(Location $location): void
    {
        //
    }

    /**
     * Handle the Location "restored" event.
     */
    public function restored(Location $location): void
    {
        //
    }

    /**
     * Handle the Location "force deleted" event.
     */
    public function forceDeleted(Location $location): void
    {
        //
    }
}
