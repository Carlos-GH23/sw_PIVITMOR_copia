<?php

namespace Database\Seeders\Company;

use App\Models\Company\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::create([
            'name' => 'Universidad Politécnica del Estado de Morelos',
            'legal_name' => 'UPEMOR',
            'rfc' => 'UPE04070782A',
            'year' => '2004',
            'user_id' => 2,
        ]);
    }
}
