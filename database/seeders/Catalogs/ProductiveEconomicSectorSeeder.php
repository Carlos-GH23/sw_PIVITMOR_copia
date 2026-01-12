<?php

namespace Database\Seeders\Catalogs;

use App\Models\Catalogs\ProductiveEconomicSector;
use Illuminate\Database\Seeder;

class ProductiveEconomicSectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductiveEconomicSector::create([
            'name' => 'Sector Primario',
            'description' => 'Incluye las actividades relacionadas con la extracción y aprovechamiento directo de los recursos naturales, como la agricultura, ganadería, pesca y silvicultura.'
        ]);

        ProductiveEconomicSector::create([
            'name' => 'Sector Secundario',
            'description' => 'Comprende las actividades industriales dedicadas a la transformación de materias primas del sector primario.'
        ]);

        ProductiveEconomicSector::create([
            'name' => 'Sector Terciario',
            'description' => 'Engloba las actividades de servicios, comercio y turismo.'
        ]);
    }
}
