<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Builder;

trait HasInstitutionRelation
{
    /**
     * Get the institution ID through user relationships
     */
    protected function institutionId(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->user?->academic?->department?->institution_id
        );
    }

    /**
     * Scope to filter by institution
     */
    public function scopeFromInstitution(Builder $query, int $institutionId): Builder
    {
        return $query->whereHas('user.academic.department', function (Builder $q) use ($institutionId) {
            $q->where('institution_id', $institutionId);
        });
    }
}
