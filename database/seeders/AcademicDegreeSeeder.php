<?php

namespace Database\Seeders;

use App\Models\AcademicDegree;
use Illuminate\Database\Seeder;

class AcademicDegreeSeeder extends Seeder
{

    public function run(): void
    {
        AcademicDegree::create([
            'name' => 'Licenciatura',
            'description' => 'Grado académico obtenido al completar estudios superiores de pregrado.'
        ]);

        AcademicDegree::create([
            'name' => 'Maestría',
            'description' => 'Grado académico de posgrado que sigue a la licenciatura, enfocado en la especialización.'
        ]);

        AcademicDegree::create([
            'name' => 'Doctorado',
            'description' => 'Grado académico de posgrado de más alto nivel, enfocado en la investigación original.'
        ]);

        AcademicDegree::create([
            'name' => 'Especialidad',
            'description' => 'Programa de estudios avanzado en un área específica, generalmente después de la licenciatura.'
        ]);
    }
}
