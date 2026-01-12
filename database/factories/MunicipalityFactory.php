<?php

namespace Database\Factories;

use App\Models\Municipality;
use App\Models\State;
use Illuminate\Database\Eloquent\Factories\Factory;

class MunicipalityFactory extends Factory
{
    protected $model = Municipality::class;

    public function definition()
    {
        return [
            'name' => $this->faker->city,
            'code' => $this->faker->numerify('###'),
            'state_id' => State::factory(),
        ];
    }
}
