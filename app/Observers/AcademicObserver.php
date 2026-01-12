<?php

namespace App\Observers;

use App\Models\Academic;
use App\Models\Institution\FacilityEquipment;
use App\Models\User;

class AcademicObserver
{
    /**
     * Handle the Academic "created" event.
     */
    public function created(Academic $academic): void
    {
        if ($academic->user_id) {
            $user = User::find($academic->user_id);

            if ($user) {
                $academic->contact()->create([
                    'email' => $user->email,
                    'name' => $academic->full_name,
                ]);
            }
        }
    }

    /**
     * Handle the Academic "updated" event.
     */
    public function updated(Academic $academic): void
    {
        $academic->capabilities()->searchable();
        $academic->technologyServices()->searchable();
        $academic->conferences()->searchable();
        FacilityEquipment::where('responsible_id', $academic->id)->searchable();
    }

    /**
     * Handle the Academic "deleted" event.
     */
    public function deleted(Academic $academic): void
    {
        //
    }

    /**
     * Handle the Academic "restored" event.
     */
    public function restored(Academic $academic): void
    {
        //
    }

    /**
     * Handle the Academic "force deleted" event.
     */
    public function forceDeleted(Academic $academic): void
    {
        //
    }
}
