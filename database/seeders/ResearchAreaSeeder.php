<?php

namespace Database\Seeders;

use App\Models\ResearchArea;
use Illuminate\Database\Seeder;

class ResearchAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ResearchArea::create([
            'name' => 'Área I: Físico Matemáticas y Ciencias de la Tierra',
            'description' => 'Área de conocimiento del Sistema Nacional de Investigadores (SNI).',
            'order' => 1,
        ]);

        ResearchArea::create([
            'name' => 'Área II: Biología y Química',
            'description' => 'Área de conocimiento del Sistema Nacional de Investigadores (SNI).',
            'order' => 2,
        ]);

        ResearchArea::create([
            'name' => 'Área III: Medicina y Ciencias de la Salud',
            'description' => 'Área de conocimiento del Sistema Nacional de Investigadores (SNI).',
            'order' => 3,
        ]);

        ResearchArea::create([
            'name' => 'Área IV: Ciencias de la Conducta y la Educación',
            'description' => 'Área de conocimiento del Sistema Nacional de Investigadores (SNI).',
            'order' => 4,
        ]);

        ResearchArea::create([
            'name' => 'Área V: Humanidades',
            'description' => 'Área de conocimiento del Sistema Nacional de Investigadores (SNI).',
            'order' => 5,
        ]);

        ResearchArea::create([
            'name' => 'Área VI: Ciencias Sociales',
            'description' => 'Área de conocimiento del Sistema Nacional de Investigadores (SNI).',
            'order' => 6,
        ]);

        ResearchArea::create([
            'name' => 'Área VII: Ciencias de Agricultura, Agropecuarias, Forestales y de Ecosistemas',
            'description' => 'Área de conocimiento del Sistema Nacional de Investigadores (SNI).',
            'order' => 7,
        ]);

        ResearchArea::create([
            'name' => 'Área VIII: Ingenierías y Desarrollo Tecnológico',
            'description' => 'Área de conocimiento del Sistema Nacional de Investigadores (SNI).',
            'order' => 8,
        ]);

        ResearchArea::create([
            'name' => 'Área IX: Interdisciplinario',
            'description' => 'Área de conocimiento del Sistema Nacional de Investigadores (SNI).',
            'order' => 9,
        ]);
    }
}
