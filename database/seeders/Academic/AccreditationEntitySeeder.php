<?php

namespace Database\Seeders\Academic;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Academic\AccreditationEntity;

class AccreditationEntitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AccreditationEntity::create(['name' => 'CONOCER']);
        AccreditationEntity::create(['name' => 'SEP']);
        AccreditationEntity::create(['name' => 'PMI']);
        AccreditationEntity::create(['name' => 'ISO']);
        
    }
}
