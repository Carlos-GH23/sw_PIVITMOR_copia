<?php

namespace Database\Seeders\Catalogs;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Catalogs\Activity;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Activity::create([
            'name' => 'Actividad cientifica y Tecnológica',
            'description' => 'Actividades relacionadas con la investigación y el desarrollo tecnológico.',
        ]);

        Activity::create([
            'name' => 'Actividad de innovación científica y tecnológica',
            'description' => 'Actividades relacionadas con la innovación en ciencia y tecnología.',
        ]);

        Activity::create([
            'name' => 'Adquisición de tecnología no incorporada',
            'description' => 'Actividades relacionadas con la adquisición de tecnología no incorporada.',
            'parent_id' => 2, // Hijo de "Actividad de innovación científica y tecnológica"
        ]);

        Activity::create([
            'name' => 'Adquisición de "know-how"',
            'description' => 'Actividades relacionadas con la adquisición de "know-how".',
            'parent_id' => 2, // Hijo de "Actividad de innovación científica y tecnológica"
        ]);
        Activity::create([
            'name' => 'Adquisición de tecnología incorporada',
            'description' => 'Actividades relacionadas con la adquisición de tecnología incorporada.',
            'parent_id' => 2, // Hijo de "Actividad de innovación científica y tecnológica"
        ]);
        Activity::create([
            'name' => 'Actividad de apoyo',
            'description' => 'Actividades relacionadas con la adquisición de apoyo.',
        ]);
    }
}
