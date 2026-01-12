<?php

namespace Database\Factories;

use App\Models\Location;
use App\Models\Neighborhood;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory
{
    protected $model = Location::class;

    public function definition()
    {
        $latitude = $this->faker->latitude(18.2, 19.1);
        $longitude = $this->faker->longitude(-99.5, -98.6);

        return [
            'street' => $this->faker->streetName,
            'exterior_number' => $this->faker->buildingNumber,
            'interior_number' => $this->faker->optional()->buildingNumber,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'neighborhood_id' => Neighborhood::inRandomOrder()->first()?->id ?? 1,
        ];
    }
}
