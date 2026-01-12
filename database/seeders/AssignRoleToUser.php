<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AssignRoleToUser extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::find(1); // user admin
        $role = Role::find(1); // role admin

        $user->assignRole($role);
        
        // $user = User::find(2); // user empresa
        // $role = Role::find(2); // role empresa
        // $user->assignRole($role);

        // $user = User::find(3); // user academico
        // $role = Role::find(3); // role academico
        // $user->assignRole($role);

        // $user = User::find(4); // user institucion
        // $role = Role::find(4); // role institucion
        // $user->assignRole($role);

        // $user = User::find(5); // user ong
        // $role = Role::find(5); // role ong
        // $user->assignRole($role);

        // $user = User::find(6); // user gobierno
        // $role = Role::find(6); // role gobierno
        // $user->assignRole($role);
    }
}
