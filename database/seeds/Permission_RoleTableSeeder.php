<?php

use Illuminate\Database\Seeder;
use Bitfumes\Multiauth\Model\Permission;
use Bitfumes\Multiauth\Model\Role;

class Permission_RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::where('name','superadmin')->first();
        $permisos = Permission::all();

        $role->syncPermissions($permisos);
    }
}
