<?php

use App\Admin;
use Illuminate\Database\Seeder;
use Bitfumes\Multiauth\Model\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*Admin::query()->delete();
        Permission::query()->delete();*/

        //maintenance:

        //Admin
        Permission::create([
            'name'       => 'admins.index',
            'description' => 'Lista y navega las credenciales',
        ]);
        Permission::create([
            'name'       => 'admins.create',
            'description' => 'Crea las credenciales'
        ]);
        Permission::create([
            'name'       => 'admins.edit',
            'description' => 'Edita los datos de las credenciales'
        ]);
        Permission::create([
            'name'       => 'admins.destroy',
            'description' => 'Elimina las credenciales'
        ]);
        //Districts
        Permission::create([
            'name'       => 'districts.index',
            'description'=> 'Lista y navega los distritos y ciudades'
        ]);
        Permission::create([
            'name'       => 'districts.create',
            'description'=> 'Crea distritos y ciudades'
        ]);
        Permission::create([
            'name'       => 'districts.edit',
            'description'=> 'Edita los distritos y ciudades'
        ]);
        Permission::create([
            'name'       => 'districts.destroy',
            'description'=> 'Elimina los distritos y ciudades'
        ]);
        //WorkStations
        Permission::create([
            'name'       => 'workstations.index',
            'description'=> 'Lista y navega las areas de trabajo'
        ]);
        Permission::create([
            'name'       => 'workstations.create',
            'description'=> 'Crea areas de trabajo'
        ]);
        Permission::create([
            'name'       => 'workstations.edit',
            'description'=> 'Editar las areas de trabajo'
        ]);
        Permission::create([
            'name'       => 'workstations.destroy',
            'description'=> 'Elimina las areas de trabajo'
        ]);
        //WorkPositions
        Permission::create([
            'name'       => 'workpositions.index',
            'description'=> 'Lista y navega los puestos de trabajo'
        ]);
        Permission::create([
            'name'       => 'workpositions.create',
            'description'=> 'Crea puestos de trabajo'
        ]);
        Permission::create([
            'name'       => 'workpositions.edit',
            'description'=> 'Edita los puestos de trabajo'
        ]);
        Permission::create([
            'name'       => 'workpositions.destroy',
            'description'=> 'Elimina un puesto de trabajo'
        ]);
        //Subsidiaries
        Permission::create([
            'name'       => 'subsidiaries.index',
            'description'=> 'Lista y navega las subisidiarias'
        ]);
        Permission::create([
            'name'       => 'subsidiaries.create',
            'description'=> 'Crea subsidiarias'
        ]);
        Permission::create([
            'name'       => 'subsidiaries.edit',
            'description'=> 'Edita las subisidiaries'
        ]);
        Permission::create([
            'name'       => 'subsidiaries.destroy',
            'description'=> 'Elimina una subisidiarie'
        ]);
        //Staff
        Permission::create([
            'name'       => 'staff.index',
            'description'=> 'Lista y navega el personal'
        ]);
        Permission::create([
            'name'       => 'staff.create',
            'description'=> 'Crea personal'
        ]);
        Permission::create([
            'name'       => 'staff.edit',
            'description'=> 'Edita el personal'
        ]);
        Permission::create([
            'name'       => 'staff.destroy',
            'description'=> 'Elimina un personal'
        ]);
    }
}
