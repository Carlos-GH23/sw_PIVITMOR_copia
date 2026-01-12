<?php

namespace Database\Seeders\Catalogs;

use App\Models\Catalogs\NewsCategory;
use Illuminate\Database\Seeder;

class NewsCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NewsCategory::create([
            'name' => 'Innovación',
            'description' => 'Noticias de innovación y desarrollo tecnológico.'
        ]);

        NewsCategory::create([
            'name' => 'Vinculación',
            'description' => 'Noticias relacionadas con la vinculación institucional'
        ]);

        NewsCategory::create([
            'name' => 'Convocatoria',
            'description' => 'Noticias relacionadas con las convocatorias'
        ]);

        NewsCategory::create([
            'name' => 'Evento',
            'description' => 'Noticias relacionadas con los eventos'
        ]);

        NewsCategory::create([
            'name' => 'Casos de éxito',
            'description' => 'Noticias relacionadas con los casos de éxito'
        ]);

        NewsCategory::create([
            'name' => 'General',
            'description' => 'Noticias generales'
        ]);
    }
}
