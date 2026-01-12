<?php

namespace Database\Factories;

use App\Models\Neighborhood;
use App\Models\Municipality;
use Illuminate\Database\Eloquent\Factories\Factory;

class NeighborhoodFactory extends Factory
{
    protected $model = Neighborhood::class;

    public function definition()
    {
        return [
            'name' => $this->faker->citySuffix,
            'postal_code' => $this->faker->postcode,
            'municipality_id' => Municipality::factory(),
        ];
    }
}
