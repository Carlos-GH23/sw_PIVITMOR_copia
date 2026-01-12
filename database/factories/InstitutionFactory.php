<?php

namespace Database\Factories;

use App\Models\Catalogs\EconomicSector;
use App\Models\Institution\Institution;
use App\Models\Catalogs\InstitutionType;
use App\Models\Catalogs\OecdSector;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class InstitutionFactory extends Factory
{
    protected $model = Institution::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'description' => $this->faker->text(200),
            'institution_type_id' => InstitutionType::inRandomOrder()->first()?->id ?? 1,
            'user_id' => User::factory(),
            'is_active' => true,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Institution $institution) {
            $oecdSectors = OecdSector::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $institution->oecdSectors()->attach($oecdSectors);

            $economicSectors = EconomicSector::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $institution->economicSectors()->attach($economicSectors);
        });
    }
}
