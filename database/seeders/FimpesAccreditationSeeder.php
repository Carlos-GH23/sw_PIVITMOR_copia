<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AcademicOfferings\FimpesAccreditation;

class FimpesAccreditationSeeder extends Seeder
{

    public function run(): void
    {
        FimpesAccreditation::create([
            'name' => 'Acreditación lisa y llana',
        ]);

        FimpesAccreditation::create([
            'name' => 'Acreditación con observaciones',
        ]);

        FimpesAccreditation::create([
            'name' => 'Candidatura a la acreditación',
        ]);

        FimpesAccreditation::create([
            'name' => 'Sin acreditación',
        ]);
    }
}
