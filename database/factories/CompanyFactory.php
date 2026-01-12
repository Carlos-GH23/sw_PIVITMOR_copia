<?php

namespace Database\Factories;

use App\Models\Catalogs\EconomicSector;
use App\Models\Catalogs\OecdSector;
use App\Models\Company\Company;
use App\Models\Company\TechnologyCompany;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'legal_name' => $this->faker->company . ' ' . $this->faker->companySuffix,
            'rfc' => $this->faker->regexify('[A-Z]{4}[0-9]{6}[A-Z0-9]{3}'),
            'year' => $this->faker->year,
            'mission' => $this->faker->text(200),
            'vision' => $this->faker->text(200),
            'overview' => $this->faker->text(200),
            'user_id' => User::factory(),
            'is_active' => true,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Company $company) {
            $technologyCompany = TechnologyCompany::create([
                'company_id' => $company->id,
                'num_employees' => rand(1, 500),
                'description' => $this->faker->text(200),
            ]);

            $oecdSectors = OecdSector::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $technologyCompany->oecdSectors()->attach($oecdSectors);

            $economicSectors = EconomicSector::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $technologyCompany->economicSectors()->attach($economicSectors);
        });
    }
}
