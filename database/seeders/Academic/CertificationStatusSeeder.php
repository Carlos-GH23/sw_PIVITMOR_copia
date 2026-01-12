<?php

namespace Database\Seeders\Academic;

use App\Models\Academic\CertificationStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CertificationStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CertificationStatus::insert([
            ['name' => 'Vigente'],
            ['name' => 'Vencido'],
            ['name' => 'Renovado'],
        ]);
    }
}
