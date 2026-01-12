<?php

namespace Database\Seeders\Institution;

use App\Models\Institution\SniLevel;
use App\Models\Institution\SniMembership;
use Illuminate\Database\Seeder;

class SniLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SniLevel::create([
            'name' => 'Candidato'
        ]);

        SniLevel::create([
            'name' => 'Nivel I'
        ]);

        SniLevel::create([
            'name' => 'Nivel II'
        ]);

        SniLevel::create([
            'name' => 'Nivel III'
        ]);

        SniLevel::create([
            'name' => 'Emérito'
        ]);
    }
}
