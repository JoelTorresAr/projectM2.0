<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\ShelfStoreRequest;
use App\Http\Requests\ShelfUpdateRequest;
use App\models\Shelf;
use Illuminate\Support\Facades\DB;

class ShelfController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DB::table('shelves')
        ->join('subsidiaries','shelves.subsidiary_id','=','subsidiaries.id')
        ->leftJoin('dealers','shelves.dealer_id','=','dealers.id')
        ->select('shelves.*','subsidiaries.name as subsidiary','dealers.name as dealer')
        ->orderBy('created_at')
        ->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShelfStoreRequest $request)
    {
        $shelf = Shelf::create([
            'name' => $request['name'],
            'subsidiary_id' => $request['subsidiary_id'],
            'rentalstatus' => $request['rentalstatus'],
            'dealer_id' => $request['dealer_id'],
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
    public function update(ShelfUpdateRequest $request, $id)
    {
        $shelf = Shelf::find($id);
        $shelf->fill([
            'name' => $request['name'],
            'subsidiary_id' => $request['subsidiary_id'],
            'rentalstatus' => $request['rentalstatus'],
            'dealer_id' => $request['dealer_id'],
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
        Shelf::findOrFail($id)->delete();
        return ['status' => '200', 'message' => 'Eliminado con exito'];
    }
}
