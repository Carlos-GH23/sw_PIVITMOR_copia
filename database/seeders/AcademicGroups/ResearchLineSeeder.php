<?php

namespace Database\Seeders\AcademicGroups;

use App\Models\AcademicGroups\ResearchLine;
use Illuminate\Database\Seeder;

class ResearchLineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ResearchLine::create([
            'name' => 'Tecnologías Inteligentes de Software ',
            'description' => ' ',
            'department_id' => 1,
        ]);
        ResearchLine::create([
            'name' => 'Ingeniería de Software',
            'description' => ' ',
            'department_id' => 1,
        ]);
        ResearchLine::create([
            'name' => 'Inteligencia Artificial',
            'description' => ' ',
            'department_id' => 1,
        ]);
        ResearchLine::create([
            'name' => 'Sistemas Térmicos',
            'description' => ' ',
            'department_id' => 3,
        ]);
        ResearchLine::create([
            'name' => 'Control',
            'description' => ' ',
            'department_id' => 2,
        ]);
    }
}
