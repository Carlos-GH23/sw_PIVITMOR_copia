<?php

namespace Database\Seeders;

use App\Models\Policy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PolicySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Policy::create([
            'cookies_policy' => 'Este es nuestro aviso de cookies...',
            'terms_and_conditions' => 'Este es nuestro aviso de términos y condiciones...',
            'legal_references' => 'Estas son nuestras referencias legales...',
        ]);
    }
}
