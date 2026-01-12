<?php

namespace Database\Seeders\Catalogs;

use Illuminate\Database\Seeder;
use App\Models\Catalogs\TechnologyServiceCategory;

class TechnologyServiceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TechnologyServiceCategory::create([
            'code' => 'ANA',
            'name' => 'Servicios de análisis y caracterización',
            'description' => 'Análisis fisicoquímicos, biológicos y de materiales; pruebas de laboratorio especializado.',
        ]);
        TechnologyServiceCategory::create([
            'code' => 'ENS',
            'name' => 'Servicios de ensayo, pruebas y certificación',
            'description' => 'Ensayos normalizados (NOM, NMX, ISO, ASTM), certificación de producto/proceso y metrología.',
        ]);
        TechnologyServiceCategory::create([
            'code' => 'DIS',
            'name' => 'Servicios de diseño e ingeniería',
            'description' => 'Diseño de prototipos, diseño industrial y optimización/automatización de procesos.',
        ]);
        TechnologyServiceCategory::create([
            'code' => 'CON',
            'name' => 'Servicios de consultoría y transferencia',
            'description' => 'Asesoría tecnológica, estudios de factibilidad e IP/licenciamiento y transferencia.',
        ]);
        TechnologyServiceCategory::create([
            'code' => 'CAP',
            'name' => 'Servicios de formación y capacitación',
            'description' => 'Cursos especializados, entrenamiento en equipos y certificación de competencias técnicas.',
        ]);
        TechnologyServiceCategory::create([
            'code' => 'I+D',
            'name' => 'Servicios de innovación y desarrollo aplicado',
            'description' => 'Desarrollo de software/soluciones, proyectos de I+D con industria y pruebas piloto/validación.',
        ]);
        TechnologyServiceCategory::create([
            'code' => 'PRO',
            'name' => 'Servicios de apoyo a la producción y escalamiento',
            'description' => 'Plantas piloto, manufactura avanzada/prototipado e integración tecnológica (IoT/automatización).',
        ]);
    }
}
