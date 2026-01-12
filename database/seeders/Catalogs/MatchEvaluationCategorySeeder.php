<?php

namespace Database\Seeders\Catalogs;

use App\Models\Catalogs\MatchEvaluationCategory;
use Illuminate\Database\Seeder;

class MatchEvaluationCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MatchEvaluationCategory::create(['name' => 'Energía y sustentabilidad', 'description' => 'Energía y sustentabilidad', 'parent_id' => null]);
        MatchEvaluationCategory::create(['name' => 'Agua, agro y alimentos', 'description' => 'Agua, agro y alimentos', 'parent_id' => null]);
        MatchEvaluationCategory::create(['name' => 'Salud y biotecnología', 'description' => 'Salud y biotecnología', 'parent_id' => null]);
        MatchEvaluationCategory::create(['name' => 'Tecnologías de información y comunicación (TIC)', 'description' => 'Tecnologías de información y comunicación (TIC)', 'parent_id' => null]);
        MatchEvaluationCategory::create(['name' => 'Manufactura avanzada e industria 4.0', 'description' => 'Manufactura avanzada e industria 4.0', 'parent_id' => null]);
        MatchEvaluationCategory::create(['name' => 'Movilidad y transporte inteligente', 'description' => 'Movilidad y transporte inteligente', 'parent_id' => null]);
        MatchEvaluationCategory::create(['name' => 'Educación y capital humano', 'description' => 'Educación y capital humano', 'parent_id' => null]);
        MatchEvaluationCategory::create(['name' => 'Sociedad e inclusión digital', 'description' => 'Sociedad e inclusión digital', 'parent_id' => null]);
        MatchEvaluationCategory::create(['name' => 'Infraestructura y ciudades inteligentes', 'description' => 'Infraestructura y ciudades inteligentes', 'parent_id' => null]);
        MatchEvaluationCategory::create(['name' => 'Gobierno e innovación pública', 'description' => 'Gobierno e innovación pública', 'parent_id' => null]);

        MatchEvaluationCategory::create(['name' => ' Tecnologías de información y comunicación (TIC)', 'description' => ' Tecnologías de información y comunicación (TIC)', 'parent_id' => 2]);
        MatchEvaluationCategory::create(['name' => ' Infraestructura y ciudades inteligentes', 'description' => ' Infraestructura y ciudades inteligentes', 'parent_id' => 2]);
    }
}
