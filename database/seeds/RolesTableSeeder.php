<?php

use Illuminate\Database\Seeder;
use Bitfumes\Multiauth\Model\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        //Admins
        Role::create([
            'name'       => 'SuperAdmin'
        ]);

        //
        Role::create([
            'name'       => 'Admin'
        ]);
    }
}
