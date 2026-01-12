<?php

namespace Database\Seeders\AcademicGroups;

use App\Models\AcademicGroups\AcademicBody;
use Illuminate\Database\Seeder;

class AcademicBodySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AcademicBody::create([
            'name' => 'Cuerpo Académico de Tecnologías Web',
            'key' => 'CENIDET-CA1',
            'review' => ' ',
            'consolidation_degree_id' => 1,
            'department_id' => 1,
        ]);

        AcademicBody::create([
            'name' => 'Cuerpo Académico de Ingeniería de Software',
            'key' => 'CENIDET-CA2',
            'review' => ' ',
            'consolidation_degree_id' => 2,
            'department_id' => 1,
        ]);

        AcademicBody::create([
            'name' => 'Cuerpo Académico de Visión Artificial',
            'key' => 'CENIDET-CA3',
            'review' => ' ',
            'consolidation_degree_id' => 3,
            'department_id' => 1,
        ]);

        AcademicBody::create([
            'name' => 'Cuerpo Académico de Térmica',
            'key' => 'CENIDET-CA4',
            'review' => ' ',
            'consolidation_degree_id' => 1,
            'department_id' => 3,
        ]);

        AcademicBody::create([
            'name' => 'Cuerpo Académico de Control',
            'key' => 'CENIDET-CA5',
            'review' => ' ',
            'consolidation_degree_id' => 2,
            'department_id' => 2,
        ]);
    }
}
