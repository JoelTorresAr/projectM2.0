<?php

namespace App\Http\Controllers\Api;

use App\Dealer;
use App\Http\Controllers\Controller;
use App\Http\Requests\DealerStoreRequest;
use App\Http\Requests\DealerUpdateRequest;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DealerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DB::table('dealers')
        ->select('id','name','email','active','created_at','updated_at')
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
        return DB::table('dealers')
        ->select('id','name','active')
        //->where('active','=',true)
        ->get();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DealerStoreRequest $request)
    {
        $now = Carbon::now();
        DB::table('dealers')->insertOrIgnore([
            'name'       => $request['name'],
            'email'      => $request['email'],
            'active'     => $request['active'],
            'password'   => Hash::make($request['password']),
            'created_at' => $now,
            'updated_at' => $now,
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
    public function update(DealerUpdateRequest $request, Dealer $dealer)
    {
        if ($request['password'] !== null) {
            $dealer->fill([
                'name'        => $request['name'],
                'email'       => $request['email'],
                'password'    => Hash::make($request['password']),
                'active'      => $request['active'],
            ])->save();
        } else {
            $dealer->fill([
                'name' => $request['name'],
                'email' => $request['email'],
                'active' => $request['active'],
            ])->save();
        }

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
        Dealer::findOrFail($id)->delete();
        return ['status' => '200', 'message' => 'Eliminado con exito'];
    }
}
