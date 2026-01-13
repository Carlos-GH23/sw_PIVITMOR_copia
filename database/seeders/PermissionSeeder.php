<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Menu Security
            ['name' => 'menu.security', 'description' => 'Acceso al menú de seguridad', 'module_key' => 'dashboard'],

            // Users
            ['name' => 'users.index', 'description' => 'Ver usuarios', 'module_key' => 'security'],
            ['name' => 'users.create', 'description' => 'Crear usuarios', 'module_key' => 'security'],
            ['name' => 'users.edit', 'description' => 'Editar usuarios', 'module_key' => 'security'],
            ['name' => 'users.delete', 'description' => 'Eliminar usuarios', 'module_key' => 'security'],

            // Roles
            ['name' => 'roles.index', 'description' => 'Ver roles', 'module_key' => 'security'],
            ['name' => 'roles.create', 'description' => 'Crear roles', 'module_key' => 'security'],
            ['name' => 'roles.edit', 'description' => 'Editar roles', 'module_key' => 'security'],
            ['name' => 'roles.delete', 'description' => 'Eliminar roles', 'module_key' => 'security'],

            // Permissions
            ['name' => 'permissions.index', 'description' => 'Ver permisos', 'module_key' => 'security'],
            ['name' => 'permissions.create', 'description' => 'Crear permisos', 'module_key' => 'security'],
            ['name' => 'permissions.edit', 'description' => 'Editar permisos', 'module_key' => 'security'],
            ['name' => 'permissions.delete', 'description' => 'Eliminar permisos', 'module_key' => 'security'],

            // Modules
            ['name' => 'modules.index', 'description' => 'Ver módulos', 'module_key' => 'security'],
            ['name' => 'modules.create', 'description' => 'Crear módulos', 'module_key' => 'security'],
            ['name' => 'modules.edit', 'description' => 'Editar módulos', 'module_key' => 'security'],
            ['name' => 'modules.delete', 'description' => 'Eliminar módulos', 'module_key' => 'security'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name']],
                $permission
            );
        }
    }
}
