<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionStoreRequest;
use App\Http\Requests\PermissionUpdateRequest;
use App\models\Permission;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DB::table('permissions')
        ->select('id','name','created_at','updated_at','description')
        ->orderBy('name')
        ->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listOnlyName()
    {
        return DB::table('permissions')
        ->select('id','name')
        ->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionStoreRequest $request)
    {
        Permission::create([
            'name' => $request['name'],
            'guard_name' => 'admin',
            'description' => $request['description'],
        ]);


        return ['status' => '200', 'message' => 'Creado con exito'];
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionUpdateRequest $request, $id)
    {
        $role = Permission::findOrFail($id);
        $role->fill([
            'name' => $request['name'],
            'description' => $request['description'],
        ])->save();


        return ['status' => '200', 'message' => 'Editado con exito'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Permission::findOrFail($id)->delete();
        return ['status' => '200', 'message' => 'Eliminado con exito'];
    }
}
