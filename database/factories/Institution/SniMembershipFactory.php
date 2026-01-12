<?php

namespace Database\Factories\Institution;

use App\Models\Academic;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Institution\SniMembership>
 */
class SniMembershipFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = fake()->date();

        return [
            'number' => fake()->unique()->numerify('SNI-#####'),
            'start_date' => $startDate,
            'end_date' => fake()->dateTimeBetween($startDate, '+5 years'),
            'academic_id' => Academic::factory(),
            'sni_level_id' => fake()->numberBetween(1,5),
            'research_area_id' => fake()->numberBetween(1,9),
        ];
    }
}
