<?php

namespace Database\Seeders\Company;

use App\Models\Company\CompanySize;
use Illuminate\Database\Seeder;

class CompanySizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CompanySize::create(['name' => 'Pequeña (0-5 empleados)']);
        CompanySize::create(['name' => 'Mediana (5-50 empleados)']);
        CompanySize::create(['name' => 'Grande (50-300 empleados)']);
    }
}
