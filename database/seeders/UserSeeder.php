<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'              => 'Administrador',
            'email'             => 'admin@gmail.com',
            'password'          => '12345678',
            'email_verified_at' => now(),
        ]);
        // User::create([
        //     'name'              => 'Empresa',
        //     'email'             => 'empresa@gmail.com',
        //     'password'          => '12345678',
        //     'email_verified_at' => now(),
        // ]);
        // User::create([
        //     'name'              => 'Académico',
        //     'email'             => 'academico@gmail.com',
        //     'password'          => '12345678',
        //     'email_verified_at' => now(),
        // ]);
        // User::create([
        //     'name'              => 'Institución',
        //     'email'             => 'institucion@gmail.com',
        //     'password'          => '12345678',
        //     'email_verified_at' => now(),
        // ]);
        // User::create([
        //     'name'              => 'ONG',
        //     'email'             => 'ong@gmail.com',
        //     'password'          => '12345678',
        //     'email_verified_at' => now(),
        // ]);
        // User::create([
        //     'name'              => 'Gobierno',
        //     'email'             => 'gobierno@gmail.com',
        //     'password'          => '12345678',
        //     'email_verified_at' => now(),
        // ]);
    }
}
