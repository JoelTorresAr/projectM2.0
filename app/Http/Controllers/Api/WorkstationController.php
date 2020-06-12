<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\WorkstationStoreRequest;
use App\Http\Requests\WorkstationUpdateRequest;
use App\models\Workstation;
use Illuminate\Support\Facades\DB;

class WorkstationController extends Controller
{
    public function index()
    {
        return DB::table('workstations')
        ->orderBy('name')
        ->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WorkstationStoreRequest $request)
    {
        Workstation::create([
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
    public function update(WorkstationUpdateRequest $request, $id)
    {
        $workstation = Workstation::findOrFail($id);
        $workstation->fill([
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
        Workstation::findOrFail($id)->delete();
        return ['status' => '200', 'message' => 'Eliminado con exito'];
    }
}
