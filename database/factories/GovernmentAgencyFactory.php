<?php

namespace Database\Factories;

use App\Models\GovernmentAgency\GovernmentAgency;
use App\Models\GovernmentAgency\GovernmentLevel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class GovernmentAgencyFactory extends Factory
{
    protected $model = GovernmentAgency::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company . ' Agency',
            'acronym' => strtoupper($this->faker->lexify('???')),
            'mission' => $this->faker->text(200),
            'vision' => $this->faker->text(200),
            'objectives' => $this->faker->text(200),
            'government_level_id' => GovernmentLevel::inRandomOrder()->first()?->id,
            'user_id' => User::factory(),
            'is_active' => true,
        ];
    }
}
