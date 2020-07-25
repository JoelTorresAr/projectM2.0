<?php

namespace App\Http\Controllers\Api;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaleStoreRequest;
use App\Http\Requests\SaleUpdateRequest;
use App\models\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DB::table('sales')
            ->orderBy('created_at')
            ->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listOnlyName()
    {
        return DB::table('roles')->pluck('name');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaleStoreRequest $request)
    {
        //Article Processed
        $now = Carbon::now('America/Lima');
        if ($user = auth('admin')->user()) {
            $userValided = Admin::find($user['id']);
            $newSale = $userValided->sales()->create([
                'dni'           => $request['dni'],
                'igv_id'        => $request['igv_id'],
                'prooftype_id'  => $request['prooftype_id'],
                'paytype'       => $request['paytype'],
                'totalpay'      => $request['totalpay'],
            ]);
            if ($newSale) {
                foreach ($request['salearticles'] as $item) {
                    DB::table('article_sale')->insert([
                        'article_id' => $item['id'],
                        'sale_id'    => $newSale['id'],
                        'quantity'   => $item['quantity'],
                        'saleprice'  => $item['import'],
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                    DB::table('articles')
                        ->where('id', $item['id'])
                        ->decrement('stock', $item['quantity']);
                }
            }
        } else {
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
    public function update(SaleUpdateRequest $request, $id)
    {
        $role = Sale::find($id);
        $role->fill([
            'name' => $request['name'],
            'description' => $request['description'],
        ])->save();

        $role->syncPermissions($request['permissions']);


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
        Sale::findOrFail($id)->delete();
        return ['status' => '200', 'message' => 'Eliminado con exito'];
    }
}
