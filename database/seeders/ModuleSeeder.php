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
        $modules = [
            ['name' => 'Seguridad', 'description' => 'Módulo de administración de seguridad', 'icon' => 'shield-check', 'is_active' => true],
            ['name' => 'Dashboard', 'description' => 'Panel de control principal', 'icon' => 'dashboard', 'is_active' => true],
        ];

        foreach ($modules as $module) {
            Module::firstOrCreate(
                ['name' => $module['name']],
                $module
            );
        }
    }
}
