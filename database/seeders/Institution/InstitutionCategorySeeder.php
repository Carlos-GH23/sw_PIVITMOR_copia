<?php

namespace Database\Seeders\Institution;

use App\Models\Institution\InstitutionCategory;
use Illuminate\Database\Seeder;

class InstitutionCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        InstitutionCategory::create([
            'code' => 'IES',
            'name' => 'Instituciones de Educación Superior (IES)',
        ]);
        InstitutionCategory::create([
            'code' => 'CI',
            'name' => 'Centros de Investigación (CI)',
        ]);
    }
}
