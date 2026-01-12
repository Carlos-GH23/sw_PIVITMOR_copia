<?php


namespace Database\Seeders;

use App\Models\Catalogs\JobOfferType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobOfferTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JobOfferType::create([
            'name' => 'Empleo Directo',
            'description' => 'Posiciones laborales abiertas en empresas e instituciones.',
        ]);
        JobOfferType::create([
            'name' => 'Prácticas/Pasantías',
            'description' => 'Programas de formación y experiencia laboral.',
        ]);
        JobOfferType::create([
            'name' => 'Consultoría',
            'description' => 'Servicios profesionales puntuales.',
        ]);
        JobOfferType::create([
            'name' => 'Investigación',
            'description' => 'Posiciones en proyectos de investigación y desarrollo.',
        ]);
        JobOfferType::create([
            'name' => 'Capacitación/Entrenamiento',
            'description' => 'Programas educativos o de desarrollo de habilidades.',
        ]);
        JobOfferType::create([
            'name' => 'Colaboración',
            'description' => 'Asociaciones o alianzas tecnológicas.',
        ]);
        JobOfferType::create([
            'name' => 'Transferencia Tecnológica',
            'description' => 'Licencias o adopción de tecnología.',
        ]);
    }
}

