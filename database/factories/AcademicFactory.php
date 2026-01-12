<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Academic>
 */
class AcademicFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'second_last_name' => fake()->lastName(),
            'biography' => fake()->paragraph(),
            'is_active' => true,
            'academic_degree_id' => fake()->numberBetween(1,4),
            'academic_position_id' => fake()->numberBetween(1,7),
            'department_id' => fake()->numberBetween(1,12),
            'gender' => fake()->numberBetween(1, 2),
        ];
    }
}
