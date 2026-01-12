<?php

namespace Database\Seeders;

use App\Models\Catalogs\EconomicSector;
use App\Models\Catalogs\GovernmentSector;
use App\Models\Catalogs\InstitutionType;
use Illuminate\Database\Seeder;
use App\Models\Institution\Institution;
use App\Models\Company\Company;
use App\Models\NonProfitOrganization;
use App\Models\GovernmentAgency\GovernmentAgency;
use App\Models\GovernmentAgency\GovernmentLevel;
use App\Models\Location;
use App\Models\Neighborhood;
use App\Models\Municipality;
use App\Models\State;
use App\Models\User;

class EcosystemSeeder extends Seeder
{
    public function run()
    {
        $neighborhoods = Neighborhood::whereHas('municipality.state', function ($query) {
            $query->where('name', 'Morelos');
        })->get();

        if ($neighborhoods->isEmpty()) {
            $this->command->error('No neighborhoods found in Morelos. Please run the main seeder first.');
            return;
        }

        $institutionTypes = InstitutionType::all();
        $economicSectors = EconomicSector::all();
        $governmentLevels = GovernmentLevel::all();
        $governmentSectors = GovernmentSector::all();

        $user = User::factory()->create();

        $institutions = [];
        $companies = [];
        $nonprofits = [];
        $agencies = [];

        for ($i = 0; $i < 50; $i++) {
            $institution = Institution::create([
                'name' => fake()->company(),
                'description' => fake()->text(200),
                'institution_type_id' => $institutionTypes->random()->id ?? 1,
                'user_id' => $user->id,
                'is_active' => true,
            ]);

            Location::create([
                'street' => fake()->streetName(),
                'exterior_number' => fake()->buildingNumber(),
                'interior_number' => fake()->optional()->buildingNumber(),
                'latitude' => (string) fake()->latitude(18.2, 19.1),
                'longitude' => (string) fake()->longitude(-99.5, -98.6),
                'neighborhood_id' => $neighborhoods->random()->id,
                'locationable_id' => $institution->id,
                'locationable_type' => Institution::class,
            ]);

            $institutions[] = $institution;
        }

        for ($i = 0; $i < 50; $i++) {
            $company = Company::create([
                'name' => fake()->company(),
                'legal_name' => fake()->company() . ' S.A. de C.V.',
                'rfc' => fake()->regexify('[A-Z]{4}[0-9]{6}[A-Z0-9]{3}'),
                'year' => (string) fake()->year(),
                'mission' => fake()->text(200),
                'vision' => fake()->text(200),
                'overview' => fake()->text(200),
                'user_id' => $user->id,
                'is_active' => true,
            ]);

            Location::create([
                'street' => fake()->streetName(),
                'exterior_number' => fake()->buildingNumber(),
                'interior_number' => fake()->optional()->buildingNumber(),
                'latitude' => (string) fake()->latitude(18.2, 19.1),
                'longitude' => (string) fake()->longitude(-99.5, -98.6),
                'neighborhood_id' => $neighborhoods->random()->id,
                'locationable_id' => $company->id,
                'locationable_type' => Company::class,
            ]);

            $companies[] = $company;
        }

        for ($i = 0; $i < 30; $i++) {
            $nonprofit = NonProfitOrganization::create([
                'name' => fake()->company() . ' Foundation',
                'description' => fake()->text(300),
                'mission' => fake()->text(200),
                'main_projects' => fake()->text(200),
                'cluni' => fake()->bothify('?????#####'),
                'rfc' => fake()->regexify('[A-Z]{4}[0-9]{6}[A-Z0-9]{3}'),
                'legal_representative' => fake()->name(),
                'economic_sector_id' => $economicSectors->random()->id ?? null,
                'user_id' => $user->id,
                'is_active' => true,
            ]);

            Location::create([
                'street' => fake()->streetName(),
                'exterior_number' => fake()->buildingNumber(),
                'interior_number' => fake()->optional()->buildingNumber(),
                'latitude' => (string) fake()->latitude(18.2, 19.1),
                'longitude' => (string) fake()->longitude(-99.5, -98.6),
                'neighborhood_id' => $neighborhoods->random()->id,
                'locationable_id' => $nonprofit->id,
                'locationable_type' => NonProfitOrganization::class,
            ]);

            $nonprofits[] = $nonprofit;
        }

        for ($i = 0; $i < 20; $i++) {
            $agency = GovernmentAgency::create([
                'name' => fake()->company() . ' Agency',
                'acronym' => strtoupper(fake()->lexify('???')),
                'mission' => fake()->text(200),
                'vision' => fake()->text(200),
                'objectives' => fake()->text(200),
                'government_level_id' => $governmentLevels->random()->id ?? null,
                'government_sector_id' => $governmentSectors->random()->id ?? null,
                'user_id' => $user->id,
                'is_active' => true,
            ]);

            Location::create([
                'street' => fake()->streetName(),
                'exterior_number' => fake()->buildingNumber(),
                'interior_number' => fake()->optional()->buildingNumber(),
                'latitude' => (string) fake()->latitude(18.2, 19.1),
                'longitude' => (string) fake()->longitude(-99.5, -98.6),
                'neighborhood_id' => $neighborhoods->random()->id,
                'locationable_id' => $agency->id,
                'locationable_type' => GovernmentAgency::class,
            ]);

            $agencies[] = $agency;
        }
    }
}
