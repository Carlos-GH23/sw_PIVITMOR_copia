<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AcademicDegree;
use App\Models\Company\JobOffer;

class JobOfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $degrees = AcademicDegree::pluck('id')->toArray();

        JobOffer::create([
            'name' => 'Ingeniero de Software',
            'position' => 'Ingeniero de Software',
            'academic_degree_id' => $degrees[0] ?? null,
            'start_date' => now()->subDays(10),
            'end_date' => now()->addDays(10),
            'user_id' => 2,
            'job_description' => 'Desarrollar y mantener aplicaciones de software.',
            'responsibilities' => 'Escribir código limpio y eficiente.',
        ]);

        JobOffer::create([
            'name' => 'Analista de Datos',
            'position' => 'Analista de Datos',
            'academic_degree_id' => $degrees[1] ?? $degrees[0] ?? null,
            'start_date' => now()->subDays(5),
            'end_date' => now()->addDays(15),
            'user_id' => 2,
            'job_description' => 'Analizar y procesar grandes volúmenes de datos.',
            'responsibilities' => 'Extraer, transformar y cargar datos.',
        ]);

        JobOffer::create([
            'name' => 'Diseñador UX/UI',
            'position' => 'Diseñador UX/UI',
            'academic_degree_id' => $degrees[2] ?? $degrees[0] ?? null,
            'start_date' => now()->subDays(2),
            'end_date' => now()->addDays(20),
            'user_id' => 2,
            'job_description' => 'Diseñar interfaces de usuario atractivas y funcionales.',
            'responsibilities' => 'Realizar pruebas de usabilidad y colaborar con desarrolladores.',
        ]);

        JobOffer::create([
            'name' => 'Administrador de Proyectos',
            'position' => 'Administrador de Proyectos',
            'academic_degree_id' => $degrees[3] ?? $degrees[0] ?? null,
            'start_date' => now()->subDays(1),
            'end_date' => now()->addDays(30),
            'user_id' => 2,
            'job_description' => 'Gestionar equipos y cronogramas de proyectos.',
            'responsibilities' => 'Coordinar tareas y asegurar el cumplimiento de plazos.',
        ]);
    }
}
