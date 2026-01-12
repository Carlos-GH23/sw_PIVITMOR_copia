<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TechnologyService;
use App\Models\TechnologyServiceStatus;


class TechnologyServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    
    public function run(): void
    {
        TechnologyServiceStatus::create(['name' => 'Borrador', 'description' => 'Borrador sin enviar a validar', 'color' => 'gray']);
        TechnologyServiceStatus::create(['name' => 'Enviado a revisión', 'description' => 'Servicio tecnológico enviado a revisión', 'color' => 'yellow']);
        TechnologyServiceStatus::create(['name' => 'Validado y autorizado', 'description' => 'Servicio tecnológico validado y autorizado', 'color' => 'green']);
        TechnologyServiceStatus::create(['name' => 'Rechazada con observaciones', 'description' => 'Servicio tecnológico rechazado, con observaciones, enviar nuevamente', 'color' => 'red']);
        TechnologyServiceStatus::create(['name' => 'Rechazada', 'description' => 'Servicio tecnológico rechazado, enviar nuevamente', 'color' => 'red']);
        TechnologyServiceStatus::create(['name' => 'Cerrado', 'description' => 'Servicio tecnológico autorizado y vencido', 'color' => 'gray']);


        // TechnologyService::create([
        //     'title' => 'Plataforma de Monitoreo IoT',
        //     'technical_description' => 'Servicio de monitoreo y control de dispositivos IoT para la industria.',
        //     'technology_service_type_id' => 1,
        //     'technology_service_category_id' => 1,
        //     'start_date' => now()->subDays(30)->toDateString(),
        //     'end_date' => now()->addDays(60)->toDateString(),
        //     'department_id' => 1,
        //     'technology_service_status_id' => 1,
        //     'user_id' => 3,
        // ]);

        // TechnologyService::create([
        //     'title' => 'Desarrollo de Software a Medida',
        //     'technical_description' => 'Soluciones de software personalizadas para empresas.',
        //     'technology_service_type_id' => 2,
        //     'technology_service_category_id' => 2,
        //     'start_date' => now()->subDays(10)->toDateString(),
        //     'end_date' => now()->addDays(90)->toDateString(),
        //     'department_id' => 2,
        //     'technology_service_status_id' => 4,
        //     'user_id' => 3,
        // ]);

        // TechnologyService::create([
        //     'title' => 'Consultoría en Ciberseguridad',
        //     'technical_description' => 'Evaluación y mejora de la seguridad informática para empresas.',
        //     'technology_service_type_id' => 3,
        //     'technology_service_category_id' => 3,
        //     'start_date' => now()->subDays(5)->toDateString(),
        //     'end_date' => now()->addDays(120)->toDateString(),
        //     'department_id' => 3,
        //     'technology_service_status_id' => 2,
        //     'user_id' => 3,
        // ]);

        // TechnologyService::create([
        //     'title' => 'Capacitación en Inteligencia Artificial',
        //     'technical_description' => 'Cursos y talleres sobre IA y machine learning para equipos técnicos.',
        //     'technology_service_type_id' => 1,
        //     'technology_service_category_id' => 4,
        //     'start_date' => now()->subDays(20)->toDateString(),
        //     'end_date' => now()->addDays(30)->toDateString(),
        //     'department_id' => 4,
        //     'technology_service_status_id' => 3,
        //     'user_id' => 3,
        // ]);
    }
}
