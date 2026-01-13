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
            ['name' => 'menu.security', 'description' => 'Acceso al menú de seguridad'],

            // Users
            ['name' => 'users.index', 'description' => 'Ver usuarios'],
            ['name' => 'users.create', 'description' => 'Crear usuarios'],
            ['name' => 'users.edit', 'description' => 'Editar usuarios'],
            ['name' => 'users.delete', 'description' => 'Eliminar usuarios'],

            // Roles
            ['name' => 'roles.index', 'description' => 'Ver roles'],
            ['name' => 'roles.create', 'description' => 'Crear roles'],
            ['name' => 'roles.edit', 'description' => 'Editar roles'],
            ['name' => 'roles.delete', 'description' => 'Eliminar roles'],

            // Permissions
            ['name' => 'permissions.index', 'description' => 'Ver permisos'],
            ['name' => 'permissions.create', 'description' => 'Crear permisos'],
            ['name' => 'permissions.edit', 'description' => 'Editar permisos'],
            ['name' => 'permissions.delete', 'description' => 'Eliminar permisos'],

            // Modules
            ['name' => 'modules.index', 'description' => 'Ver módulos'],
            ['name' => 'modules.create', 'description' => 'Crear módulos'],
            ['name' => 'modules.edit', 'description' => 'Editar módulos'],
            ['name' => 'modules.delete', 'description' => 'Eliminar módulos'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name']],
                $permission
            );
        }
    }
}
