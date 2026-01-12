<?php

namespace Database\Seeders\Academic;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Academic\CertificationLevel;

class CertificationLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CertificationLevel::create(['name' => 'Intermedio']);
        CertificationLevel::create(['name' => 'Avanzado']);
        CertificationLevel::create(['name' => 'Especialista']);
        
    }
}
