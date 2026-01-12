<?php

namespace Database\Seeders\Company;

use App\Models\Company\MarketReach;
use Illuminate\Database\Seeder;

class MarketReachSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MarketReach::create(['name' => 'Local']);
        MarketReach::create(['name' => 'Estatal']);
        MarketReach::create(['name' => 'Nacional']);
        MarketReach::create(['name' => 'Internacional']);
    }
}
