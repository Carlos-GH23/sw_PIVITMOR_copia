<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Module::create([
            'name' => 'Módulo de seguridad',
            'description' => 'Módulos de seguridad',
            'key' => 'seg',
            'user_id' => 1,
        ]);

        Module::create([
            'name' => 'Configuración de sistema',
            'description' => 'Módulo de configuración de sistema',
            'key' => 'config',
            'user_id' => 1,
        ]);

        Module::create([
            'name' => 'Menú',
            'description' => 'Control de acceso del menú',
            'key' => 'menu',
            'user_id' => 1,
        ]);

        Module::create([
            'name' => 'Catálogos',
            'description' => 'Módulo de catálogos',
            'key' => 'cat',
            'user_id' => 1,
        ]);

        Module::create([
            'name' => 'Institución Educativa',
            'description' => 'Módulo de institución educativa',
            'key' => 'institution',
            'user_id' => 1,
        ]);

        // temp
        Module::create([
            'name' => 'Módulo temporal',
            'description' => 'Módulo temporal',
            'key' => 'temp',
            'user_id' => 1,
        ]);

        Module::create([
            'name' => 'Empresa',
            'description' => 'Módulo de empresa',
            'key' => 'company',
            'user_id' => 1,
        ]);

        Module::create([
            'name' => 'Perfiles',
            'description' => 'Módulo de perfiles',
            'key' => 'profile',
            'user_id' => 1,
        ]);

        Module::create([
            'name' => 'Dashboard',
            'description' => 'Módulo de dashboard',
            'key' => 'dashboard',
            'user_id' => 1,
        ]);
    }
}
