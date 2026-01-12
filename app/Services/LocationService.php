<?php

namespace App\Services;

use App\Models\Location;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class LocationService
{
    private const ALLOWED_FIELDS = [
        'neighborhood_id',
        'postal_code',
        'street',
        'exterior_number',
        'interior_number',
        'latitude',
        'longitude',
    ];

    private const REQUIRED_FIELDS = ['postal_code', 'neighborhood_id'];

    public function upsertLocation(Model $locationable, array $locationData): ?Location
    {
        $filteredData = Arr::only($locationData, self::ALLOWED_FIELDS);

        if (!$this->validateLocationData($filteredData)) {
            DB::transaction(function () use ($locationable) {
                $locationable->location()->delete();
            });
            return null;
        }

        return DB::transaction(function () use ($locationable, $filteredData) {
            return $locationable->location()->updateOrCreate(
                [
                    'locationable_id' => $locationable->id,
                    'locationable_type' => get_class($locationable)
                ],
                $filteredData
            );
        });
    }

    private function validateLocationData(array $data): bool
    {
        return collect(self::REQUIRED_FIELDS)
            ->every(fn($field) => !empty($data[$field]));
    }
}
