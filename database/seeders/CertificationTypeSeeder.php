<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Catalogs\CertificationType;

class CertificationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CertificationType::create([
            'name' => 'Conocimientos',
            'description' => 'Certificación que valida conocimientos en un área específica.',
        ]);
        CertificationType::create([
            'name' => 'Habilidades',
            'description' => 'Certificación que valida habilidades generales.',
        ]);
        CertificationType::create([
            'name' => 'Infraestructura',
            'description' => 'Certificación relacionada con infraestructura.',
        ]);
        CertificationType::create([
            'name' => 'Instalación',
            'description' => 'Certificación de instalaciones.',
        ]);
        CertificationType::create([
            'name' => 'Laboral',
            'description' => 'Certificación laboral.',
        ]);
        CertificationType::create([
            'name' => 'Recursos humanos',
            'description' => 'Certificación de recursos humanos.',
        ]);
        CertificationType::create([
            'name' => 'Servicios',
            'description' => 'Certificación de servicios.',
        ]);
    }
}
