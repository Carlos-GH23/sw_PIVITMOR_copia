<?php

namespace App\Observers;

use App\Models\AcademicGroups\AcademicBody;

class AcademicBodyObserver
{
    /**
     * Handle the AcademicBody "created" event.
     */
    public function created(AcademicBody $academicBody): void
    {
        //
    }

    /**
     * Handle the AcademicBody "updated" event.
     */
    public function updated(AcademicBody $academicBody): void
    {
        $academicBody->academics()->searchable();
    }

    /**
     * Handle the AcademicBody "deleted" event.
     */
    public function deleted(AcademicBody $academicBody): void
    {
        //
    }

    /**
     * Handle the AcademicBody "restored" event.
     */
    public function restored(AcademicBody $academicBody): void
    {
        //
    }

    /**
     * Handle the AcademicBody "force deleted" event.
     */
    public function forceDeleted(AcademicBody $academicBody): void
    {
        //
    }
}
