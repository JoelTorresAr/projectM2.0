<?php

namespace App\Http\Controllers\Api;
use App\models\City;
use App\Http\Controllers\Controller;
use App\Http\Requests\CityStoreRequest;
use App\Http\Requests\CityUpdateRequest;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{
    public function index()
    {
        return DB::table('cities')
        ->orderBy('name')
        ->get();
    }    
        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showbydistrict($id)
    {
        return DB::table('cities')
        ->join('districts','cities.id','=','districts.city_id')
        ->select('cities.*')
        ->where('districts.id',$id)
        ->limit(1)
        ->get();
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CityStoreRequest $request)
    {
        City::create([
            'name' => $request['name']
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
    public function update(CityUpdateRequest $request, $id)
    {
        $city = City::findOrFail($id);
        $city->fill([
            'name' => $request['name']
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
        City::findOrFail($id)->delete();
        return ['status' => '200', 'message' => 'Eliminado con exito'];
    }
}
