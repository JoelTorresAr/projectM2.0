<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProoftypeStoreRequest;
use App\Http\Requests\ProoftypeUpdateRequest;
use App\models\Prooftype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProoftypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DB::table('prooftypes')
        ->orderBy('name')
        ->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProoftypeStoreRequest $request)
    {
        Prooftype::create([
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
    public function update(ProoftypeUpdateRequest $request, $id)
    {
        $prooftype = Prooftype::find($id);
        $prooftype->fill([
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
        Prooftype::findOrFail($id)->delete();
        return ['status' => '200', 'message' => 'Eliminado con exito'];
    }
}
