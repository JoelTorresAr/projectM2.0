<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProviderStoreRequest;
use App\Http\Requests\ProviderUpdateRequest;
use App\models\Provider;
use Illuminate\Support\Facades\DB;

class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DB::table('providers')
            ->join('districts', 'providers.district_id', '=', 'districts.id')
            ->join('cities', 'districts.city_id', '=', 'cities.id')
            ->select('providers.*','districts.name as district','cities.id as city_id','cities.name as city')
            ->orderBy('name')
            ->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProviderStoreRequest $request)
    {
        Provider::create([
            'name'        => $request['name'],
            'district_id' => $request['district_id'],
            'address'     => $request['address'],
            'address2'    => $request['address2'],
            'ruc'         => $request['ruc'],
            'phone1'      => $request['phone1'],
            'phone2'      => $request['phone2'],
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
    public function update(ProviderUpdateRequest $request, $id)
    {
        $offer = Provider::findOrFail($id);
        $offer->fill([
            'name'     => $request['name'],
            'discount' => $request['discount'],
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
        Provider::findOrFail($id)->delete();
        return ['status' => '200', 'message' => 'Eliminado con exito'];
    }
}
