<?php

namespace Database\Seeders\Catalogs;

use App\Models\Catalogs\LegalEntityType;
use Illuminate\Database\Seeder;

class LegalEntityTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LegalEntityType::create([
            'name' => 'Asociación civil (A.C.)',
        ]);
        LegalEntityType::create([
            'name' => 'Institución de Asistencia Privada (I.A.P.)',
        ]);
        LegalEntityType::create([
            'name' => 'Fundación',
        ]);
        LegalEntityType::create([
            'name' => 'Cooperativa',
        ]);
        LegalEntityType::create([
            'name' => 'Otra',
        ]);
    }
}
