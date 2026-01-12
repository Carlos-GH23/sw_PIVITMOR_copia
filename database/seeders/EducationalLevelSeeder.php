<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AcademicOfferings\EducationalLevel;

class EducationalLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EducationalLevel::create([
            'name' => 'Doctorado en ciencias',
        ]);
        EducationalLevel::create([
            'name' => 'Especialización',
        ]);
        EducationalLevel::create([
            'name' => 'Licenciatura',
        ]);
        EducationalLevel::create([
            'name' => 'Maestría con orientación profesional',
        ]);
        EducationalLevel::create([
            'name' => 'Maestría en ciencias',
        ]);
    }
}
