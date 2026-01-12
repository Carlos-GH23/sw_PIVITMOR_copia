<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class MockupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // temp
        Permission::create(['name' => 'dashboard.capabiltyRecords', 'guard_name' => 'web', 'description' => 'Permiso temporal', 'module_key' => 'temp']);

        Permission::create(['name' => 'requests', 'guard_name' => 'web', 'description' => 'Permiso temporal', 'module_key' => 'temp']);
        Permission::create(['name' => 'successStories', 'guard_name' => 'web', 'description' => 'Permiso temporal', 'module_key' => 'temp']);
        Permission::create(['name' => 'contents', 'guard_name' => 'web', 'description' => 'Permiso temporal', 'module_key' => 'temp']);
        Permission::create(['name' => 'portalDesigns', 'guard_name' => 'web', 'description' => 'Permiso temporal', 'module_key' => 'temp']);
        Permission::create(['name' => 'maintenance', 'guard_name' => 'web', 'description' => 'Permiso temporal', 'module_key' => 'temp']);
        Permission::create(['name' => 'settings', 'guard_name' => 'web', 'description' => 'Permiso temporal', 'module_key' => 'temp']);
        Permission::create(['name' => 'searches', 'guard_name' => 'web', 'description' => 'Permiso temporal', 'module_key' => 'temp']);

        Permission::create(['name' => 'vinculationEvaluations.requirements.index', 'guard_name' => 'web', 'description' => 'Permiso temporal', 'module_key' => 'temp']);
        Permission::create(['name' => 'vinculationEvaluations.capabilities.index', 'guard_name' => 'web', 'description' => 'Permiso temporal', 'module_key' => 'temp']);
    }
}
