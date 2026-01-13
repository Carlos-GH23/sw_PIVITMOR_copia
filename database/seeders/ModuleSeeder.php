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
            ['name' => 'Seguridad', 'description' => 'Módulo de administración de seguridad', 'key' => 'security'],
            ['name' => 'Dashboard', 'description' => 'Panel de control principal', 'key' => 'dashboard'],
        ];

        foreach ($modules as $module) {
            Module::firstOrCreate(
                ['key' => $module['key']],
                $module
            );
        }
    }
}
