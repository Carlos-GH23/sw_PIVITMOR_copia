<?php

namespace Database\Seeders\Catalogs;

use Illuminate\Database\Seeder;
use App\Models\Catalogs\IntellectualProperty;

class IntellectualPropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        IntellectualProperty::create([
            'name' => 'Derechos de autor',
        ]);

        IntellectualProperty::create([
            'name' => 'Diseño industrial',
        ]);

        IntellectualProperty::create([
            'name' => 'Dibujos y Modelos Industriales',
        ]);

        IntellectualProperty::create([
            'name' => 'Esquema de Trazado de Circuitos Integrados',
        ]);

        IntellectualProperty::create([
            'name' => 'Indicación Geográfica / Denominación de Origen',
        ]);

        IntellectualProperty::create([
            'name' => 'Marca Comercial',
        ]);

        IntellectualProperty::create([
            'name' => 'Nombre Comercial',
        ]);

        IntellectualProperty::create([
            'name' => 'Modelo de Utilidad',
        ]);

        IntellectualProperty::create([
            'name' => 'Patente',
        ]);

        IntellectualProperty::create([
            'name' => 'Secreto Industrial',
        ]);
    }
}
