<?php

namespace Database\Factories;

use App\Models\NonProfitOrganization;
use App\Models\User;
use App\Models\Catalogs\EconomicSector;
use App\Models\Catalogs\LegalEntityType;
use App\Models\Company\MarketReach;
use Illuminate\Database\Eloquent\Factories\Factory;

class NonProfitOrganizationFactory extends Factory
{
    protected $model = NonProfitOrganization::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'description' => $this->faker->paragraph,
            'mission' => $this->faker->paragraph,
            'main_projects' => $this->faker->paragraph,
            'cluni' => $this->faker->bothify('?????#####'),
            'rfc' => $this->faker->regexify('[A-Z]{4}[0-9]{6}[A-Z0-9]{3}'),
            'legal_representative' => $this->faker->name,
            'economic_sector_id' => EconomicSector::inRandomOrder()->first()?->id,
            'legal_entity_type_id' => LegalEntityType::inRandomOrder()->first()?->id,
            'market_reach_id' => MarketReach::inRandomOrder()->first()?->id,
            'user_id' => User::factory(),
            'is_active' => true,
        ];
    }
}
