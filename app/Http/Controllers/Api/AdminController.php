<?php

namespace App\Http\Controllers\Api;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminAssignRequest;
use App\Http\Requests\AdminStoreRequest;
use App\Http\Requests\AdminUpdateRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        return Admin::with([
            'roles' => function ($query) {
                $query->select('roles.id', 'roles.name');
            },
            'staff' => function ($query2) {
                $query2->select('staff.id', 'staff.name as staffname', 'staff.lastname as stafflastname','staff.admin_id');
            },
        ])->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listOnlyName()
    {
        return  DB::table('admins')
            ->leftJoin('staff', 'staff.admin_id', '=', 'admins.id')
            ->select('admins.id', 'admins.name')
            ->whereNull('staff.admin_id')
            ->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminStoreRequest $request)
    {
        $admin = Admin::create([
            'name'        => $request['name'],
            'email'       => $request['email'],
            'password'    => Hash::make($request['password']),
            'active'     => $request['active'],
            'description' => $request['description'],
            'api_token'   => Str::random(60),
        ]);
        if ($request['roles'] !== null) {
            $admin->roles()->attach($request['roles']);
        }


        return ['status' => '200', 'message' => 'Creado con exito'];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminUpdateRequest $request, $id)
    {
        $admin = Admin::findOrFail($id);
        if ($request['password'] !== null) {
            $admin->fill([
                'name'        => $request['name'],
                'email'       => $request['email'],
                'password'    => Hash::make($request['password']),
                'description' => $request['description'],
                'active'      => $request['active'],
                'api_token'   => Str::random(60),
            ])->save();
        } else {
            $admin->fill([
                'name' => $request['name'],
                'email' => $request['email'],
                'description' => $request['description'],
                'active'      => $request['active'],
                'api_token'   => Str::random(60),
            ])->save();
        }

        $admin->roles()->sync($request['roles']);

        return ['status' => '200', 'message' => 'Editado con exito'];
    }
    /**
     * Assign credential to specific staff.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function assign(AdminAssignRequest $request, $id)
    {
        $admin = Admin::findOrFail($id);
        $admin->fill([
            'staff_id' => $request['staff_id'],
        ])->save();

        return ['status' => '200', 'message' => 'Asignado con exito'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Admin::findOrFail($id)->delete();
        return ['status' => '200', 'message' => 'Eliminado con exito'];
    }
}
