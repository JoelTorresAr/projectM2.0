<?php

namespace App\Http\Controllers\Api;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\OfferStoreRequest;
use App\Http\Requests\OfferUpdateRequest;
use App\models\Offer;
use Illuminate\Support\Facades\DB;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DB::table('offers')
            ->orderBy('name')
            ->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OfferStoreRequest $request)
    {
        //Offer Processed
        if ($user = auth('admin')->user()) {
            $userValided = Admin::find($user['id']);
            $userValided->offers()->create([
                'name'     => $request['name'],
                'discount' => $request['discount'],
                'active'   => true,
            ]);
        } else {
            $user = auth('dealer')->user();
            $userValided = Admin::find($user['id']);
            $userValided->offers()->create([
                'name'     => $request['name'],
                'discount' => $request['discount'],
                'active'   => true,
            ]);
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
    public function update(OfferUpdateRequest $request, $id)
    {
        $offer = Offer::findOrFail($id);
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
        Offer::findOrFail($id)->delete();
        return ['status' => '200', 'message' => 'Eliminado con exito'];
    }
}
