<?php

namespace Database\Seeders\Institution;

use Illuminate\Database\Seeder;
use App\Models\Institution\Department;
use App\Models\AcademicOfferings\AcademicOffering;
use App\Models\AcademicOfferings\EducationalLevel;
use App\Models\AcademicOfferings\StudyMode;
use App\Models\AcademicOfferings\PostgraduateDetail;
use App\Models\AcademicOfferings\FimpesAccreditation;
use App\Models\AcademicOfferings\CieesAccreditation;
use App\Models\AcademicOfferings\CopaesAccreditation;
use App\Models\Keyword;
use App\Models\Catalogs\EconomicSector;
use App\Models\Catalogs\OecdSector;

class AcademicOfferingSeeder extends Seeder
{

    public function run()
    {
        AcademicOffering::create([
            'name' => 'Ingeniería en Sistemas Computacionales',
            'description' => 'Ingeniería en Sistemas Computacionales',
            'educational_level_id' => 3,
            'study_mode_id' => 2,
            'department_id' => 2,
            'user_id' => 4,
        ]);

        AcademicOffering::create([
            'name' => 'Maestría en Ciencias de la Computación ',
            'description' => 'Maestría en Ciencias de la Computación ',
            'educational_level_id' => 1,
            'study_mode_id' => 1,
            'department_id' => 4,
            'user_id' => 4,
        ]);

        AcademicOffering::create([
            'name' => 'Doctorado en Ciencias Computacionales',
            'description' => 'Doctorado en Ciencias Computacionales',
            'educational_level_id' => 1,
            'study_mode_id' => 4,
            'department_id' => 5,
            'user_id' => 4,
        ]);

        AcademicOffering::create([
            'name' => 'Especialidad en Electrónica',
            'description' => 'Especialidad en Electrónica',
            'educational_level_id' => 2,
            'study_mode_id' => 1,
            'department_id' => 1,
            'user_id' => 4,
        ]);

        AcademicOffering::create([
            'name' => 'Doctorado en Ciencias de la Ingeniería',
            'description' => 'Doctorado en Ciencias de la Ingeniería',
            'educational_level_id' => 4,
            'study_mode_id' => 4,
            'department_id' => 4,
            'user_id' => 4,
        ]);

        AcademicOffering::create([
            'name' => 'Ingeniería en Sistemas Computacionales',
            'description' => 'Programa enfocado en el desarrollo de software, redes y gestión de tecnologías de la información.',
            'educational_level_id' => 1,
            'study_mode_id' => 1,
            'department_id' => 3,
            'user_id' => 4,
        ]);

        AcademicOffering::create([
            'name' => 'Licenciatura en Administración',
            'description' => 'Formación integral en gestión empresarial, finanzas, contabilidad y liderazgo organizacional.',
            'educational_level_id' => 1,
            'study_mode_id' => 2,
            'department_id' => 1,
            'user_id' => 4,
        ]);

        AcademicOffering::create([
            'name' => 'Ingeniería Industrial',
            'description' => 'Carrera orientada a la optimización de procesos productivos y mejora continua.',
            'educational_level_id' => 1,
            'study_mode_id' => 1,
            'department_id' => 5,
            'user_id' => 4,
        ]);

        AcademicOffering::create([
            'name' => 'Licenciatura en Contaduría Pública',
            'description' => 'Estudios centrados en auditoría, impuestos, gestión contable y análisis financiero.',
            'educational_level_id' => 1,
            'study_mode_id' => 1,
            'department_id' => 1,
            'user_id' => 4,
        ]);

        AcademicOffering::create([
            'name' => 'Ingeniería Mecatrónica',
            'description' => 'Programa que combina mecánica, electrónica y control para el desarrollo de sistemas automatizados.',
            'educational_level_id' => 1,
            'study_mode_id' => 1,
            'department_id' => 1,
            'user_id' => 4,
        ]);
    }
}
