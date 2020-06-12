<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\WorkpositionStoreRequest;
use App\Http\Requests\WorkpositionUpdateRequest;
use App\models\Workposition;
use Illuminate\Support\Facades\DB;

class WorkpositionController extends Controller
{
    public function index()
    {
        return DB::table('workpositions')
        ->join('workstations','workpositions.workstation_id','=','workstations.id')
        ->select('workpositions.*','workstations.name as workstation')
        ->orderBy('name')
        ->get();
    }
    public function showbyworkstation($id)
    {
        return DB::table('workpositions')
        ->join('workstations','workpositions.workstation_id','=','workstations.id')
        ->select('workpositions.*')
        ->where('workstations.id',$id)
        ->orderBy('name')
        ->get();
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WorkpositionStoreRequest $request)
    {
        Workposition::create([
            'name' => $request['name'],
            'workstation_id' => $request['workstation_id'],
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
    public function update(WorkpositionUpdateRequest $request, $id)
    {
        $role = Workposition::findOrFail($id);
        $role->fill([
            'name' => $request['name'],
            'workstation_id' => $request['workstation_id'],
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
        Workposition::findOrFail($id)->delete();
        return ['status' => '200', 'message' => 'Eliminado con exito'];
    }
}
