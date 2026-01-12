<?php

namespace Database\Seeders\GovernmentAgency;

use App\Models\GovernmentAgency\GovernmentAgency;
use App\Models\GovernmentSector;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class GovernmentAgencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        GovernmentAgency::create([
            'name' => 'Agencia Nacional de Protección Ambiental',
            'acronym' => 'ANPA',
            'mission' => 'Proteger y preservar el medio ambiente mediante la regulación y supervisión de actividades industriales y comerciales.',
            'vision' => 'Ser una agencia líder en la promoción de prácticas sostenibles y la conservación ambiental a nivel nacional e internacional.',
            'objectives' => 'Implementar políticas ambientales efectivas, fomentar la educación ambiental y promover la participación ciudadana en la protección del entorno natural.',
            'government_level_id' => 1,
            'government_sector_id' => 3,
            'user_id' => 6,
        ]);
    }
}
