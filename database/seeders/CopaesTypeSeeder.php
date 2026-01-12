<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AcademicOfferings\CopaesAccreditation;

class CopaesTypeSeeder extends Seeder
{
    public function run(): void
    {
        CopaesAccreditation::create([
            'name' => 'ACCECISO',
            'description' => 'Descripción para ACCECISO.'
        ]);

        CopaesAccreditation::create([
            'name' => 'ANPADEH',
            'description' => 'Descripción para ANPADEH.'
        ]);

        CopaesAccreditation::create([
            'name' => 'ANPROMAR',
            'description' => 'Descripción para ANPROMAR.'
        ]);

        CopaesAccreditation::create([
            'name' => 'CACEB',
            'description' => 'Descripción para CACEB.'
        ]);

        CopaesAccreditation::create([
            'name' => 'CACECA',
            'description' => 'Descripción para CACECA.'
        ]);

        CopaesAccreditation::create([
            'name' => 'CACEI',
            'description' => 'Descripción para CACEI.'
        ]);
    }
}
