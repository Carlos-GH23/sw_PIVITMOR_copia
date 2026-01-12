<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AudienceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $audienceTypes = [
            ['type' => 'Estudiantes'],
            ['type' => 'Docentes'],
            ['type' => 'Público en General'],
            ['type' => 'Sector Empresarial'],
        ];

        DB::table('audience_types')->insert($audienceTypes);
    }
}
