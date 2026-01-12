<?php

namespace App\Observers;

use App\Models\NonProfitOrganization;
use App\Models\Requirement;

class NonProfitOrganizationObserver
{
    /**
     * Handle the NonProfitOrganization "created" event.
     */
    public function created(NonProfitOrganization $nonProfitOrganization): void
    {
        //
    }

    /**
     * Handle the NonProfitOrganization "updated" event.
     */
    public function updated(NonProfitOrganization $nonProfitOrganization): void
    {
        Requirement::where('user_id', $nonProfitOrganization->user_id)->searchable();
    }

    /**
     * Handle the NonProfitOrganization "deleted" event.
     */
    public function deleted(NonProfitOrganization $nonProfitOrganization): void
    {
        //
    }

    /**
     * Handle the NonProfitOrganization "restored" event.
     */
    public function restored(NonProfitOrganization $nonProfitOrganization): void
    {
        //
    }

    /**
     * Handle the NonProfitOrganization "force deleted" event.
     */
    public function forceDeleted(NonProfitOrganization $nonProfitOrganization): void
    {
        //
    }
}
