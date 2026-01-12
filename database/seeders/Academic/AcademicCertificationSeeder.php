<?php

namespace Database\Seeders\Academic;

use App\Models\Academic\AcademicCertification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcademicCertificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AcademicCertification::create([
        'name' => 'Project Management Professional (PMP)', 
        'description' => 'Certificación reconocida internacionalmente para la gestión de proyectos.',
        'certifying_entity' => 'Project Management Institute (PMI)',
        'accreditation_entity_id' => 1,
        'country_id' => 1,
        'issue_date' => '2022-01-15',
        'expiry_date' => '2025-01-15',
        'certification_level_id' => 1,
        'validity_duration' => 36,
        'status_id' => 2,
        ]);
    }
}
