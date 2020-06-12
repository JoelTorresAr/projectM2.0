<?php


namespace App\Http\Controllers\Api;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\StaffStoreRequest;
use App\Http\Requests\StaffUpdateRequest;
use App\models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DB::table('staff')
            ->join('subsidiaries', 'staff.subsidiary_id', '=', 'subsidiaries.id')
            ->join('workpositions', 'staff.workposition_id', '=', 'workpositions.id')
            ->join('workstations', 'workpositions.workstation_id', '=', 'workstations.id')
            ->join('districts', 'staff.district_id', '=', 'districts.id')
            ->join('cities', 'districts.city_id', '=', 'cities.id')
            ->select(
                'staff.*',
                'subsidiaries.name as subsidiary',
                'workpositions.name as workposition',
                'workstations.id as workstation_id',
                'workstations.name as workstation',
                'districts.name as district',
                'cities.id as city_id',
                'cities.name as city'
            )
            ->orderBy('subsidiary')
            ->orderBy('workposition')->get();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function nonCredentialStaff()
    {
        return  DB::table('admins')
            ->rightJoin('staff', 'admins.staff_id', '=', 'staff.id')
            ->select('staff.id', 'staff.name', 'staff.lastname')
            ->whereNull('admins.staff_id')
            ->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StaffStoreRequest $request)
    {
        $staff = Staff::create($request->all());
        if ($request['credential'] !== null) {
            $admin = Admin::findOrFail($request['credential']);
            $admin->fill(['staff_id' =>  $staff['id']])->save();
        }

        return ['status' => '200', 'message' => 'Creado con exito'];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StaffUpdateRequest $request, $id)
    {
        $staff = Staff::find($id);
        
        if ($request['credential'] !== null) {
            $admin = Admin::findOrFail($request['credential']);
            $admin->fill(['staff_id' =>  $staff['id']])->save();
        }
        $admin = Admin::findOrFail($request['credential']);
        $admin->fill(['staff_id' =>  $staff['id']])->save();

        $staff->fill($request->all())->save();

        return ['status' => '200', 'message' => 'Actualizado con exito'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Staff::findOrFail($id)->delete();
        return ['status' => '200', 'message' => 'Eliminado con exito'];
    }
}
