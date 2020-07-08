<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\models\Shelf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConcessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listShelvesAvailablesbySubsidiary($id)
    {
        return DB::table('shelves')
        ->join('subsidiaries','shelves.subsidiary_id','=','subsidiaries.id')
        ->select('shelves.id','shelves.name')
        ->where('shelves.rentalstatus','DISABLE')
        ->where('subsidiaries.id',$id)
        ->orderBy('shelves.name')
        ->get();
    }
        /**
     *  Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $shelf = Shelf::find($request['shelf_id']);
        $shelf->fill([
            'rentalstatus' => 'ENABLE',
            'dealer_id' => $id,
        ])->save();

        return ['status' => '200', 'message' => 'Creado con exito'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shelf = Shelf::find($id);
        $shelf->fill([
            'rentalstatus' => 'DISABLE',
            'dealer_id' => NULL,
        ])->save();
        return ['status' => '200', 'message' => 'Eliminado con exito'];
    }
}
