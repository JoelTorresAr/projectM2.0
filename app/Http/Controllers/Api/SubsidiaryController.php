<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubsidiaryStoreRequest;
use App\Http\Requests\SubsidiaryUpdateRequest;
use App\models\Subsidiary;
use Illuminate\Support\Facades\DB;

class SubsidiaryController extends Controller
{
    
    public function index()
    {
        return DB::table('subsidiaries')
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
        return DB::table('subsidiaries')
        ->select('id','name')
        ->get();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubsidiaryStoreRequest $request)
    {
        Subsidiary::create([
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
    public function update(SubsidiaryUpdateRequest $request, $id)
    {
        $subsidiary = Subsidiary::findOrFail($id);
        $subsidiary->fill([
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
        Subsidiary::findOrFail($id)->delete();
        return ['status' => '200', 'message' => 'Eliminado con exito'];
    }
}
