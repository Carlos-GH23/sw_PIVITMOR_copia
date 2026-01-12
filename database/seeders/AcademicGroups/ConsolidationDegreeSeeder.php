<?php

namespace Database\Seeders\AcademicGroups;

use Illuminate\Database\Seeder;
use App\Models\AcademicGroups\ConsolidationDegree;

class ConsolidationDegreeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ConsolidationDegree::create([
            'name' => 'Cuerpo Académico en Consolidación',
            'level' => 'CAEC',
        ]);
        ConsolidationDegree::create([
            'name' => 'Cuerpo Académico Consolidado',
            'level' => 'CAC',
        ]);
        ConsolidationDegree::create([
            'name' => 'Cuerpo Académico en Formación',
            'level' => 'CAEF',
        ]);
    }
}
