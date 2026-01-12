<?php

namespace Database\Seeders\Catalogs;

use App\Models\Catalogs\SocialSector;
use Illuminate\Database\Seeder;

class SocialSectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SocialSector::create([
            'name' => 'Sector público',
            'description' => 'Descripción del sector público.'
        ]);

        SocialSector::create([
            'name' => 'Sector privado',
            'description' => 'Descripción del sector privado.'
        ]);
    }
}
