<?php

namespace App\Observers;

use App\Models\Institution\Facility;
use App\Models\Institution\FacilityEquipment;

class FacilityObserver
{
    /**
     * Handle the Facility "created" event.
     */
    public function created(Facility $facility): void
    {
        //
    }

    /**
     * Handle the Facility "updated" event.
     */
    public function updated(Facility $facility): void
    {
        FacilityEquipment::where('facility_id', $facility->id)->searchable();
        $facility->technologyServices()->searchable();
    }

    /**
     * Handle the Facility "deleted" event.
     */
    public function deleted(Facility $facility): void
    {
        //
    }

    /**
     * Handle the Facility "restored" event.
     */
    public function restored(Facility $facility): void
    {
        //
    }

    /**
     * Handle the Facility "force deleted" event.
     */
    public function forceDeleted(Facility $facility): void
    {
        //
    }
}
