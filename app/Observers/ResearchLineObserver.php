<?php

namespace App\Observers;

use App\Models\AcademicGroups\AcademicBody;
use App\Models\AcademicGroups\ResearchLine;

class ResearchLineObserver
{
    /**
     * Handle the ResearchLine "created" event.
     */
    public function created(ResearchLine $researchLine): void
    {
        //
    }

    /**
     * Handle the ResearchLine "updated" event.
     */
    public function updated(ResearchLine $researchLine): void
    {
        $researchLine->academics()->searchable();

        AcademicBody::whereHas('researchLines', function ($query) use ($researchLine) {
            $query->where('research_lines.id', $researchLine->id);
        })->searchable();
    }

    /**
     * Handle the ResearchLine "deleted" event.
     */
    public function deleted(ResearchLine $researchLine): void
    {
        //
    }

    /**
     * Handle the ResearchLine "restored" event.
     */
    public function restored(ResearchLine $researchLine): void
    {
        //
    }

    /**
     * Handle the ResearchLine "force deleted" event.
     */
    public function forceDeleted(ResearchLine $researchLine): void
    {
        //
    }
}
