<?php

namespace Database\Seeders\Catalogs;

use App\Models\Catalogs\KnowledgeArea;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KnowledgeAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KnowledgeArea::create([
            'name' => 'FÍSICA',
            'parent_id' => null
        ]);

        KnowledgeArea::create([
            'name' => 'MATEMÁTICAS',
            'parent_id' => null
        ]);

        KnowledgeArea::create([
            'name' => 'QUÍMICA',
            'parent_id' => null
        ]);

        KnowledgeArea::create([
            'name' => 'Álgebra',
            'parent_id' => 2
        ]);

        KnowledgeArea::create([
            'name' => 'Ánalisis y Ánalisis funcional',
            'parent_id' => 2
        ]);

        KnowledgeArea::create([
            'name' => 'Ciencia de la computación',
            'parent_id' => 2
        ]);
    }
}
