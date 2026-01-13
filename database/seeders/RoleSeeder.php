<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Super Admin role with all permissions
        $superAdmin = Role::firstOrCreate(
            ['name' => 'Super Admin'],
            ['description' => 'Administrador del sistema con acceso completo']
        );

        $allPermissions = Permission::all();
        $superAdmin->syncPermissions($allPermissions);

        // Create Admin role
        $admin = Role::firstOrCreate(
            ['name' => 'Admin'],
            ['description' => 'Administrador con permisos limitados']
        );

        $adminPermissions = Permission::whereIn('name', [
            'users.index',
            'users.create',
            'users.edit',
            'roles.index',
            'permissions.index',
            'modules.index',
        ])->get();
        $admin->syncPermissions($adminPermissions);

        // Create User role
        $user = Role::firstOrCreate(
            ['name' => 'User'],
            ['description' => 'Usuario básico del sistema']
        );
    }
}
