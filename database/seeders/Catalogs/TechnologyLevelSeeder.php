<?php

namespace Database\Seeders\Catalogs;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Catalogs\TechnologyLevel as TLR;
use Illuminate\Database\Seeder;

class TechnologyLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TLR::create([
            'level' => 'TLR 1',
            'name' => 'TLR 1-Principios básicos observados',
        ]);

        TLR::create([
            'level' => 'TLR 2',
            'name' => 'TLR 2-Formulación del concepto tecnológico',
        ]);

        TLR::create([
            'level' => 'TLR 3',
            'name' => 'TLR 2-Prueba experimental del concepto',
        ]);

        TLR::create([
            'level' => 'TLR 4',
            'name' => 'TLR 4-Validación de componentes en laboratorio',
        ]);

        TLR::create([
            'level' => 'TLR 5',
            'name' => 'TLR 5-Validación en entorno relevante',
        ]);

        TLR::create([
            'level' => 'TLR 6',
            'name' => 'TLR 6-Demostración en entorno relevante',
        ]);
        TLR::create([
            'level' => 'TLR 7',
            'name' => 'TLR 7-Demostración en entorno operativo',
        ]);
        TLR::create([
            'level' => 'TLR 8',
            'name' => 'TLR 8-Sistema completo y certificado',
        ]);
        TLR::create([
            'level' => 'TLR 9',
            'name' => 'TLR 9-Sistema probado en operación real',
        ]);

    }
}
