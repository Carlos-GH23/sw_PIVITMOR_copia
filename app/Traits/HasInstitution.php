<?php

namespace App\Traits;

use App\Models\Institution\Institution;

trait HasInstitution
{
    /**
     * Get the user's institution ID
     */
    public function getInstitutionId(): ?int
    {
        return $this->institution?->id ?? $this->academic?->department?->institution_id;
    }

    public function getUserInstitution(): ?Institution
    {
        return $this->institution ?? $this->academic?->department?->institution;
    }

    /**
     * Check if user has an institution
     */
    public function hasInstitution(): bool
    {
        return $this->getInstitutionId() !== null;
    }
}
