<?php

namespace Database\Seeders;

use App\Models\AcademicPosition;
use Illuminate\Database\Seeder;

class AcademicPositionSeeder extends Seeder
{

    public function run(): void
    {
        AcademicPosition::create([
            'name' => 'Profesor-Investigador',
            'description' => 'Personal académico que combina docencia con actividades de investigación.'
        ]);
        AcademicPosition::create([
            'name' => 'Profesor por Asignatura',
            'description' => 'Docente contratado para impartir una o más asignaturas específicas.'
        ]);
        AcademicPosition::create([
            'name' => 'Profesor',
            'description' => 'Personal dedicado principalmente a la docencia.'
        ]);
        AcademicPosition::create([
            'name' => 'Profesor-Titular',
            'description' => 'Categoría académica de mayor jerarquía, usualmente con plaza definitiva.'
        ]);
        AcademicPosition::create([
            'name' => 'Investigador',
            'description' => 'Personal dedicado principalmente a proyectos y actividades de investigación.'
        ]);
        AcademicPosition::create([
            'name' => 'Técnico Académico',
            'description' => 'Personal de apoyo en laboratorios, talleres y otras actividades académicas.'
        ]);
        AcademicPosition::create([
            'name' => 'Coordinador',
            'description' => 'Responsable de la gestión y coordinación de un área o programa académico.'
        ]);
    }
}

