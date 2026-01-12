<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AcademicOfferings\CieesAccreditation;

class CieesAreaSeeder extends Seeder
{

    public function run(): void
    {
        CieesAccreditation::create([
            'name' => 'Arquitectura, Diseño y Urbanismo',
            'description' => 'Descripción para el área de Arquitectura, Diseño y Urbanismo.'
        ]);

        CieesAccreditation::create([
            'name' => 'Artes, Educación y Humanidades',
            'description' => 'Descripción para el área de Artes, Educación y Humanidades.'
        ]);

        CieesAccreditation::create([
            'name' => 'Ciencias Agropecuarias',
            'description' => 'Descripción para el área de Ciencias Agropecuarias.'
        ]);

        CieesAccreditation::create([
            'name' => 'Ciencias de la Salud',
            'description' => 'Descripción para el área de Ciencias de la Salud.'
        ]);

        CieesAccreditation::create([
            'name' => 'Ciencias Naturales y Exactas',
            'description' => 'Descripción para el área de Ciencias Naturales y Exactas.'
        ]);

        CieesAccreditation::create([
            'name' => 'Ciencias Sociales y Administrativas',
            'description' => 'Descripción para el área de Ciencias Sociales y Administrativas.'
        ]);

        CieesAccreditation::create([
            'name' => 'Ingeniería y Tecnología',
            'description' => 'Descripción para el área de Ingeniería y Tecnología.'
        ]);
    }
}
