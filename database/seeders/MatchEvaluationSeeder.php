<?php

namespace Database\Seeders;

use App\Models\MatchEvaluation;
use App\Models\MatchEvaluationStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MatchEvaluationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MatchEvaluationStatus::create(['name' => 'Borrador', 'description' => 'Evaluación en borrador', 'color' => 'yellow']);
        MatchEvaluationStatus::create(['name' => 'Publicada', 'description' => 'Evaluación finalizada', 'color' => 'green']);
        MatchEvaluationStatus::create(['name' => 'Archivada', 'description' => 'Evaluación archivada', 'color' => 'gray']);
    }
}
