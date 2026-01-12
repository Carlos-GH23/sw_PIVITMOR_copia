<?php

namespace Database\Seeders;

use App\Models\EconomicSocialSector;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EconomicSocialSectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EconomicSocialSector::create(['name' => 'Aeroespacial']);
        EconomicSocialSector::create(['name' => 'Agua, agro y alimentos']);
        EconomicSocialSector::create(['name' => 'Automotriz y electromovilidad']);
        EconomicSocialSector::create(['name' => 'Bienes de consumo']);
        EconomicSocialSector::create(['name' => 'Educación']);
        EconomicSocialSector::create(['name' => 'Eléctrico-electrónico y semiconductores']);
        EconomicSocialSector::create(['name' => 'Energía']);
        EconomicSocialSector::create(['name' => 'Inclusión y bienestar']);
        EconomicSocialSector::create(['name' => 'Minero-metalúrgico']);
        EconomicSocialSector::create(['name' => 'Salud']);
        EconomicSocialSector::create(['name' => 'Seguridad alimentaria']);
        EconomicSocialSector::create(['name' => 'Telecomunicaciones']);
        EconomicSocialSector::create(['name' => 'TI y economía digital']);
        EconomicSocialSector::create(['name' => 'Turismo']);
        EconomicSocialSector::create(['name' => 'Vivienda y hábitat']);
    }
}
