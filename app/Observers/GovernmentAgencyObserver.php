<?php

namespace App\Observers;

use App\Models\GovernmentAgency\GovernmentAgency;
use App\Models\Requirement;

class GovernmentAgencyObserver
{
    /**
     * Handle the GovernmentAgency "created" event.
     */
    public function created(GovernmentAgency $governmentAgency): void
    {
        //
    }

    /**
     * Handle the GovernmentAgency "updated" event.
     */
    public function updated(GovernmentAgency $governmentAgency): void
    {
        Requirement::where('user_id', $governmentAgency->user_id)->searchable();
    }

    /**
     * Handle the GovernmentAgency "deleted" event.
     */
    public function deleted(GovernmentAgency $governmentAgency): void
    {
        //
    }

    /**
     * Handle the GovernmentAgency "restored" event.
     */
    public function restored(GovernmentAgency $governmentAgency): void
    {
        //
    }

    /**
     * Handle the GovernmentAgency "force deleted" event.
     */
    public function forceDeleted(GovernmentAgency $governmentAgency): void
    {
        //
    }
}
