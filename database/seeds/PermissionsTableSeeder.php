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
        //Articles
        Permission::create([
            'name'       => 'articles.index',
            'description'=> 'Lista y navega los articulos'
        ]);
        Permission::create([
            'name'       => 'articles.create',
            'description'=> 'Crea articulo'
        ]);
        Permission::create([
            'name'       => 'articles.edit',
            'description'=> 'Edita el articulo'
        ]);
        Permission::create([
            'name'       => 'articles.destroy',
            'description'=> 'Elimina un articulo'
        ]);
        //Categories
        Permission::create([
            'name'       => 'categories.index',
            'description'=> 'Lista y navega las categorias de los productos'
        ]);
        Permission::create([
            'name'       => 'categories.create',
            'description'=> 'Crea las categorias de los productos'
        ]);
        Permission::create([
            'name'       => 'categories.edit',
            'description'=> 'Edita las categorias de los productos'
        ]);
        Permission::create([
            'name'       => 'categories.destroy',
            'description'=> 'Elimina las categorias de los productos'
        ]);
        //Cities
        Permission::create([
            'name'       => 'cities.index',
            'description'=> 'Lista y navega las ciudades'
        ]);
        Permission::create([
            'name'       => 'cities.create',
            'description'=> 'Crea las ciudades'
        ]);
        Permission::create([
            'name'       => 'cities.edit',
            'description'=> 'Edita las ciudades'
        ]);
        Permission::create([
            'name'       => 'cities.destroy',
            'description'=> 'Elimina las ciudades'
        ]);
        //Dashboard
        Permission::create([
            'name'       => 'dashboards.index',
            'description'=> 'Lista y navega los dashboards'
        ]);
        Permission::create([
            'name'       => 'dashboards.create',
            'description'=> 'Crea los dashboards'
        ]);
        Permission::create([
            'name'       => 'dashboards.edit',
            'description'=> 'Edita los dashboards'
        ]);
        Permission::create([
            'name'       => 'dashboards.destroy',
            'description'=> 'Elimina los dashboards'
        ]);
        //Dealers
        Permission::create([
            'name'       => 'dealers.index',
            'description'=> 'Lista y navega los dealers'
        ]);
        Permission::create([
            'name'       => 'dealers.create',
            'description'=> 'Crea los dealers'
        ]);
        Permission::create([
            'name'       => 'dealers.edit',
            'description'=> 'Edita los dealers'
        ]);
        Permission::create([
            'name'       => 'dealers.destroy',
            'description'=> 'Elimina los dealers'
        ]);
        //Districts
        Permission::create([
            'name'       => 'districts.index',
            'description'=> 'Lista y navega los distritos'
        ]);
        Permission::create([
            'name'       => 'districts.create',
            'description'=> 'Crea distritos'
        ]);
        Permission::create([
            'name'       => 'districts.edit',
            'description'=> 'Edita los distritos'
        ]);
        Permission::create([
            'name'       => 'districts.destroy',
            'description'=> 'Elimina los distritos'
        ]);
        //Igvs
        Permission::create([
            'name'       => 'igvs.index',
            'description'=> 'Lista y navega los IGVS'
        ]);
        Permission::create([
            'name'       => 'igvs.create',
            'description'=> 'Crea los IGVS'
        ]);
        Permission::create([
            'name'       => 'igvs.edit',
            'description'=> 'Edita los IGVS'
        ]);
        Permission::create([
            'name'       => 'igvs.destroy',
            'description'=> 'Elimina los IGVS'
        ]);
        //Offers
        Permission::create([
            'name'       => 'offers.index',
            'description'=> 'Lista y navega las ofertas'
        ]);
        Permission::create([
            'name'       => 'offers.create',
            'description'=> 'Crea ofertas'
        ]);
        Permission::create([
            'name'       => 'offers.edit',
            'description'=> 'Edita las ofertas'
        ]);
        Permission::create([
            'name'       => 'offers.destroy',
            'description'=> 'Elimina las ofertas'
        ]);
        //Permissions
        Permission::create([
            'name'       => 'permissions.index',
            'description'=> 'Lista y navega los permisos'
        ]);
        Permission::create([
            'name'       => 'permissions.create',
            'description'=> 'Crea ofertas'
        ]);
        Permission::create([
            'name'       => 'permissions.edit',
            'description'=> 'Edita los permisos'
        ]);
        Permission::create([
            'name'       => 'permissions.destroy',
            'description'=> 'Elimina los permisos'
        ]);
        //Prooftypes
        Permission::create([
            'name'       => 'prooftypes.index',
            'description'=> 'Lista y navega los tipos de comprobantes de venta'
        ]);
        Permission::create([
            'name'       => 'prooftypes.create',
            'description'=> 'Crea los tipos de comprobantes de venta'
        ]);
        Permission::create([
            'name'       => 'prooftypes.edit',
            'description'=> 'Edita los tipos de comprobantes de venta'
        ]);
        Permission::create([
            'name'       => 'prooftypes.destroy',
            'description'=> 'Elimina los tipos de comprobantes de venta'
        ]);
        //Providers
        Permission::create([
            'name'       => 'providers.index',
            'description'=> 'Lista y navega los proveedores'
        ]);
        Permission::create([
            'name'       => 'providers.create',
            'description'=> 'Crea los proveedores'
        ]);
        Permission::create([
            'name'       => 'providers.edit',
            'description'=> 'Edita los proveedores'
        ]);
        Permission::create([
            'name'       => 'providers.destroy',
            'description'=> 'Elimina los proveedores'
        ]);
        //Roles
        Permission::create([
            'name'       => 'roles.index',
            'description'=> 'Lista y navega los roles'
        ]);
        Permission::create([
            'name'       => 'roles.create',
            'description'=> 'Crea los roles'
        ]);
        Permission::create([
            'name'       => 'roles.edit',
            'description'=> 'Edita los roles'
        ]);
        Permission::create([
            'name'       => 'roles.destroy',
            'description'=> 'Elimina los roles'
        ]);
        //Shelves
        Permission::create([
            'name'       => 'shelves.index',
            'description'=> 'Lista y navega los estantes'
        ]);
        Permission::create([
            'name'       => 'shelves.create',
            'description'=> 'Crea personal'
        ]);
        Permission::create([
            'name'       => 'shelves.edit',
            'description'=> 'Edita los estantes'
        ]);
        Permission::create([
            'name'       => 'shelves.destroy',
            'description'=> 'Elimina los estantes'
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
        //Sale
        Permission::create([
            'name'       => 'sale.index',
            'description'=> 'Lista y navega las ventas'
        ]);
        Permission::create([
            'name'       => 'sale.create',
            'description'=> 'Crea ventas'
        ]);
        Permission::create([
            'name'       => 'sale.edit',
            'description'=> 'Editar las ventas'
        ]);
        Permission::create([
            'name'       => 'sale.destroy',
            'description'=> 'Elimina las ventas'
        ]);
    }
}
