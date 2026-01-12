<?php

namespace Database\Seeders;

use App\Models\ContactInformation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactInformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContactInformation::create([
            'email' => 'ccytem@morelos.gob.mx',
            'address' => 'Museo de Ciencia, Calle La Ronda, Jacarandas, Cuernavaca, Morelos, 62410, Mexico',
            'latitude' => 18.9191070,
            'longitude' => -99.2271354,
            'opening_time' => '09:00:00',
            'closing_time' => '17:00:00',
        ]);
    }
}
