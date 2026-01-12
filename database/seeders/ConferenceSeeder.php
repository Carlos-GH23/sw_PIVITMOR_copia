<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Conference;
use App\Models\ConferenceStatus;
use Illuminate\Support\Facades\DB;

class ConferenceSeeder extends Seeder
{
    public function run(): void
    {
        ConferenceStatus::create(['name' => 'Borrador', 'description' => 'Borrador sin enviar a validar', 'color' => 'gray']);
        ConferenceStatus::create(['name' => 'Publicada', 'description' => 'Conferencia publicada', 'color' => 'green']);
        ConferenceStatus::create(['name' => 'Deshabilitada', 'description' => 'Conferencia cancelada', 'color' => 'red']);
        // IDs requeridos
        // $languageId = DB::table('languages')->value('id');
        // $departmentId = DB::table('departments')->value('id');
        // $academicId = DB::table('academics')->value('id');

        // $titles = [
        //     'Conferencia de ejemplo 1',
        //     'Conferencia de ejemplo 2',
        //     'Conferencia de ejemplo 3',
        // ];

        // foreach ($titles as $i => $title) {
        //    $conference = Conference::create([
        //         'title' => $title,
        //         'modality' => 'Presencial',
        //         'language_id' => $languageId,
        //         'start_date' => now()->addDays(5 + $i)->toDateString(),
        //         'end_date' => now()->addDays(5 + $i)->toDateString(),
        //         'department_id' => $departmentId,
        //         'conference_status_id' => $i + 1, 
        //         'user_id' => 3,
        //     ]);

        //     $conference->audienceTypes()->sync([1]);
        //     $conference->academics()->sync([$academicId]);
        //     $conference->keywords()->createMany([
        //         ['name' => 'ejemplo'],
        //     ]);
        // }
    }
}