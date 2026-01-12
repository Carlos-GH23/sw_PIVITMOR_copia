<?php

namespace Database\Seeders\Company;

use App\Models\Company\InnovationType;
use Illuminate\Database\Seeder;

class InnovationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        InnovationType::create(['name' => 'Radical']);
        InnovationType::create(['name' => 'Incremental']);
    }
}
