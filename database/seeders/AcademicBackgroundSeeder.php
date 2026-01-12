<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Academic\AcademicBackground;
use Illuminate\Support\Facades\DB;

class AcademicBackgroundSeeder extends Seeder
{
    public function run(): void
    {
        $academicDegreeId = DB::table('academic_degrees')->value('id');
        $knowledgeAreaId = DB::table('knowledge_areas')->value('id');
        $countryId = DB::table('countries')->value('id');

        for ($i = 1; $i <= 3; $i++) {
            AcademicBackground::create([
                'academic_title' => 'Título académico ' . $i,
                'institution_name' => 'Institución ' . $i,
                'academic_degree_id' => $academicDegreeId,
                'knowledge_area_id' => $knowledgeAreaId,
                'country_id' => $countryId,
                'degree_obtained_at' => now()->subYears(5 + $i)->toDateString(),
                'certificate_number' => 1000 + $i,
                'academic_id' => 1,
            ]);
        }
    }
}
