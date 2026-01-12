<?php

namespace Database\Seeders\Catalogs;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResourceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['name' => 'Instalaciones especializadas', 'description' => 'Recursos relacionados con las instalaciones de la institución'],
            ['name' => 'Recursos Tecnológicos', 'description' => 'Recursos relacionados con tecnología, equipos informáticos y herramientas digitales'],
            ['name' => 'Capital Humano', 'description' => 'Recursos relacionados con el personal, profesores, investigadores y colaboradores'],
        ];

        DB::table('resource_types')->insert($types);
    }
}
