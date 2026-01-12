<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AcademicOfferings\StudyMode;

class StudyModeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StudyMode::create([
            'name' => 'A Distancia/Virtual',
        ]);
        StudyMode::create([
            'name' => 'Abierto',
        ]);
        StudyMode::create([
            'name' => 'Escolarizado',
        ]);
        StudyMode::create([
            'name' => 'Presencial',
        ]);
        StudyMode::create([
            'name' => 'Semanal',
        ]);
    }
}
