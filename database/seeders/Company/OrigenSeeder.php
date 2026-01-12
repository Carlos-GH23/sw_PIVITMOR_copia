<?php

namespace Database\Seeders\Company;

use App\Models\Company\Origen;
use Illuminate\Database\Seeder;

class OrigenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Origen::create(['name' => 'Spin-off académico']);
        Origen::create(['name' => 'Spin-off corporativo']);
        Origen::create(['name' => 'Startup']);
        Origen::create(['name' => 'Incubada']);
    }
}
