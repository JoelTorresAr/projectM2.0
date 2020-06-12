<?php

use Illuminate\Database\Seeder;
use Bitfumes\Multiauth\Model\role;
use Bitfumes\Multiauth\Model\Admin;

class Admin_RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       //SuperAdmin
       $admin = Admin::where('email','djoel_torres@hotmail.com')->first();
       $admin->roles()->attach(Role::where('name','superadmin')->first());

       //admin
       $role = Role::where('name','admin')->first();
       
       $admin = Admin::where('email','luis_sanchez@hotmail.com')->first();
       $admin->roles()->attach($role);
       
       $admin = Admin::where('email','jose_alonzo@hotmail.com')->first();
       $admin->roles()->attach($role);
    }
}
