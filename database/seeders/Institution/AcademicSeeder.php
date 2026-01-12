<?php

namespace Database\Seeders\Institution;

use App\Models\Academic;
use App\Models\Contact;
use Illuminate\Database\Seeder;

class AcademicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Academic::create([
            'first_name' => 'Elena',
            'last_name' => 'Rodríguez',
            'second_last_name' => 'Pérez',
            'biography' => 'Doctora en Inteligencia Artificial con más de 15 años de experiencia en el campo del aprendizaje automático y redes neuronales. Líder de múltiples proyectos de investigación financiados a nivel nacional.',
            'is_active' => true,
            'user_id' => 3,
            'academic_degree_id' => 1,
            'academic_position_id' => 1,
            'department_id' => 1,
        ]);
    }
}
