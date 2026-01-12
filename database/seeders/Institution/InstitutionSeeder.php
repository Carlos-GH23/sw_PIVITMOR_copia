<?php

namespace Database\Seeders\Institution;

use App\Models\Institution\Institution;
use Illuminate\Database\Seeder;
use Illuminate\Validation\Rules\In;

class InstitutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Institution::create([
            'name' => 'Universidad Nacional Autónoma de México',
            'description' => 'La Universidad Nacional Autónoma de México (UNAM) es una universidad privada ubicada en México.',
            'institution_type_id' => 1,
            'user_id' => 4,
        ]);

        Institution::create([
            'name' => 'Universidad Autónoma de Madrid',
            'description' => 'La Universidad Autónoma de Madrid (UMA) es una universidad privada ubicada en España.',
            'institution_type_id' => 5,
            'user_id' => 4,
        ]);

        Institution::create([
            'name' => 'Universidad Autónoma de Buenos Aires',
            'description' => 'La Universidad Autónoma de Buenos Aires (UBA) es una universidad privada ubicada en Argentina.',
            'institution_type_id' => 1,
            'user_id' => 4,
        ]);

        Institution::create([
            'name' => 'Universidad Autónoma de Colombia',
            'description' => 'La Universidad Autónoma de Colombia (UCA) es una universidad privada ubicada en Colombia.',
            'institution_type_id' => 5,
            'user_id' => 4,
        ]);

        Institution::create([
            'name' => 'Universidad Autónoma de Perú',
            'description' => 'La Universidad Autónoma de Perú (UAP) es una universidad privada ubicada en Perú.',
            'institution_type_id' => 1,
            'user_id' => 4,
        ]);

        Institution::create([
            'name' => 'Universidad Autónoma de Chile',
            'description' => 'La Universidad Autónoma de Chile (UAC) es una universidad privada ubicada en Chile.',
            'institution_type_id' => 5,
            'user_id' => 4,
        ]);

        Institution::create([
            'name' => 'Universidad Autónoma de Ecuador',
            'description' => 'La Universidad Autónoma de Ecuador (UE) es una universidad privada ubicada en Ecuador.',
            'institution_type_id' => 1,
            'user_id' => 4,
        ]);

        Institution::create([
            'name' => 'Universidad Autónoma de Rusia',
            'description' => 'La Universidad Autónoma de Rusia (UFR) es una universidad privada ubicada en Rusia.',
            'institution_type_id' => 5,
            'user_id' => 4,
        ]);
    }
}
