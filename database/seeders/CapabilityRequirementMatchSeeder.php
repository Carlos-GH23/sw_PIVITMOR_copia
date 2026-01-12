<?php

namespace Database\Seeders;

use App\Models\CapabilityRequirementMatch;
use App\Models\MatchStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CapabilityRequirementMatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MatchStatus::create([
            'name' => 'Empatado',
            'description' => 'La necesidad y la capacidad fueron vinculadas automáticamente por el sistema tras identificar compatibilidad.',
            'color' => 'blue',
        ]);

        MatchStatus::create([
            'name' => 'En proceso de aceptación',
            'description' => 'El proceso de vinculación está pendiente de confirmación por parte del ofertante.',
            'color' => 'yellow',
        ]);

        MatchStatus::create([
            'name' => 'Vinculado',
            'description' => 'Ambas partes han aceptado la vinculación.',
            'color' => 'green',
        ]);

        MatchStatus::create([
            'name' => 'Rechazado por ofertante',
            'description' => 'El ofertante ha rechazado la vinculación propuesta; el proceso queda cerrado para esta combinación.',
            'color' => 'red',
        ]);

        MatchStatus::create([
            'name' => 'Rechazado por demandante',
            'description' => 'El demandante ha rechazado la vinculación propuesta; el proceso queda cerrado para esta combinación.',
            'color' => 'red',
        ]);

        // CapabilityRequirementMatch::create([
        //     'compatibility_score' => 0.85,
        //     'requirement_id' => 1,
        //     'capability_id' => 2,
        //     'match_status_id' => 1,
        // ]);
        // CapabilityRequirementMatch::create([
        //     'compatibility_score' => 0.85,
        //     'requirement_id' => 2,
        //     'capability_id' => 2,
        //     'match_status_id' => 1,
        // ]);
        // CapabilityRequirementMatch::create([
        //     'compatibility_score' => 0.85,
        //     'requirement_id' => 2,
        //     'capability_id' => 3,
        //     'match_status_id' => 1,
        // ]);
        // CapabilityRequirementMatch::create([
        //     'compatibility_score' => 0.85,
        //     'requirement_id' => 4,
        //     'capability_id' => 4,
        //     'match_status_id' => 1,
        // ]);
        // CapabilityRequirementMatch::create([
        //     'compatibility_score' => 0.85,
        //     'requirement_id' => 1,
        //     'capability_id' => 4,
        //     'match_status_id' => 1,
        // ]);
        
    }
}
