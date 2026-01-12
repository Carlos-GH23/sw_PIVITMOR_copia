<?php

namespace Database\Seeders\AcademicGroups;

use Illuminate\Database\Seeder;
use App\Models\AcademicGroups\AcademicDiscipline;

class AcademicDisciplineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AcademicDiscipline::create([
            'name' => 'Agropecuarias',
        ]);
        AcademicDiscipline::create([
            'name' => 'Educación, humanidades y artes',
        ]);
        AcademicDiscipline::create([
            'name' => 'Ingeniería y tecnología',
        ]);
        AcademicDiscipline::create([
            'name' => 'Naturales y exactas',
        ]);
        AcademicDiscipline::create([
            'name' => 'Salud',
        ]);
        AcademicDiscipline::create([
            'name' => 'Sociales y administrativas',
        ]);
    }
}
