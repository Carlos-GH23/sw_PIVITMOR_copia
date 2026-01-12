<?php

namespace App\Traits;

trait IndexesOwnerEntity
{
    protected function getOwnerSearchData(): array
    {
        $owner = $this->user->owner_entity;

        if (!$owner) {
            return [
                'institution_name' => null,
                'institution_category' => null,
                'institution_code' => null,
                'municipality_id' => null,
                'state_id' => null,
                'state' => null,
                'municipality' => null,
            ];
        }

        return [
            'institution_name' => $owner->getEntityName(),
            'institution_category' => $owner->getEntityCategory(),
            'institution_code' => $owner->getEntityCode(),
            'municipality_id' => $owner->location?->neighborhood?->municipality_id,
            'state_id' => $owner->location?->neighborhood?->municipality->state_id,
            'state' => $owner->location?->neighborhood?->municipality?->state?->name,
            'municipality' => $owner->location?->neighborhood?->municipality?->name,
            'latitude' => (float) $owner->location?->latitude,
            'longitude' => (float) $owner->location?->longitude,
        ];
    }

    public function getOwnerCode(): ?string
    {
        $owner = $this->user->owner_entity;
        return $owner?->getEntityCode() ?? null;
    }
}
