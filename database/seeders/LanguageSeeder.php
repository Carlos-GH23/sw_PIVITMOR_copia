<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = [
            ['name' => 'Español'],
            ['name' => 'Inglés'],
            ['name' => 'Francés'],
        ];

        DB::table('languages')->insert($languages);
    }
}
