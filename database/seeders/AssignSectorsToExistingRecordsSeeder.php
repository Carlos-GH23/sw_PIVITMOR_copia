<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Institution\Institution;
use App\Models\Company\Company;
use App\Models\Company\TechnologyCompany;
use App\Models\Catalogs\OecdSector;
use App\Models\Catalogs\EconomicSector;

class AssignSectorsToExistingRecordsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->assignSectorsToInstitutions();
        $this->assignSectorsToCompanies();
    }

    private function assignSectorsToInstitutions(): void
    {
        $institutions = Institution::all();
        $oecdSectorIds = OecdSector::pluck('id')->toArray();
        $economicSectorIds = EconomicSector::pluck('id')->toArray();

        if (empty($oecdSectorIds) || empty($economicSectorIds)) {
            return;
        }

        foreach ($institutions as $institution) {
            if ($institution->oecdSectors()->count() === 0) {
                $randomOecdSectors = array_rand(array_flip($oecdSectorIds), min(rand(1, 3), count($oecdSectorIds)));
                $institution->oecdSectors()->attach(is_array($randomOecdSectors) ? $randomOecdSectors : [$randomOecdSectors]);
            }

            if ($institution->economicSectors()->count() === 0) {
                $randomEconomicSectors = array_rand(array_flip($economicSectorIds), min(rand(1, 3), count($economicSectorIds)));
                $institution->economicSectors()->attach(is_array($randomEconomicSectors) ? $randomEconomicSectors : [$randomEconomicSectors]);
            }
        }
    }

    private function assignSectorsToCompanies(): void
    {
        $companies = Company::all();
        $oecdSectorIds = OecdSector::pluck('id')->toArray();
        $economicSectorIds = EconomicSector::pluck('id')->toArray();

        if (empty($oecdSectorIds) || empty($economicSectorIds)) {
            return;
        }

        foreach ($companies as $company) {
            $technologyCompany = $company->technologyCompany;

            if (!$technologyCompany) {
                $technologyCompany = TechnologyCompany::create([
                    'company_id' => $company->id,
                    'num_employees' => rand(1, 500),
                    'description' => 'Technology company for ' . $company->name,
                ]);
            }

            if ($technologyCompany->oecdSectors()->count() === 0) {
                $randomOecdSectors = array_rand(array_flip($oecdSectorIds), min(rand(1, 3), count($oecdSectorIds)));
                $technologyCompany->oecdSectors()->attach(is_array($randomOecdSectors) ? $randomOecdSectors : [$randomOecdSectors]);
            }

            if ($technologyCompany->economicSectors()->count() === 0) {
                $randomEconomicSectors = array_rand(array_flip($economicSectorIds), min(rand(1, 3), count($economicSectorIds)));
                $technologyCompany->economicSectors()->attach(is_array($randomEconomicSectors) ? $randomEconomicSectors : [$randomEconomicSectors]);
            }
        }
    }
}
