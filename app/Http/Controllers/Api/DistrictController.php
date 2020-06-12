<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\DistrictStoreRequest;
use App\Http\Requests\DistrictUpdateRequest;
use App\models\District;
use Illuminate\Support\Facades\DB;

class DistrictController extends Controller
{
    public function index()
    {
        return DB::table('districts')
        ->join('cities','districts.city_id','=','cities.id')
        ->select('districts.*','cities.name as city')
        ->orderBy('name')
        ->get();
    }

        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showbycity($id)
    {
        return DB::table('districts')
        ->join('cities','districts.city_id','=','cities.id')
        ->select('districts.*')
        ->where('cities.id',$id)
        ->orderBy('name')
        ->get();
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DistrictStoreRequest $request)
    {
        District::create([
            'name' => $request['name'],
            'city_id' => $request['city_id'],
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
    public function update(DistrictUpdateRequest $request, $id)
    {
        $role = District::findOrFail($id);
        $role->fill([
            'name' => $request['name'],
            'city_id' => $request['city_id'],
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
        District::findOrFail($id)->delete();
        return ['status' => '200', 'message' => 'Eliminado con exito'];
    }
}
