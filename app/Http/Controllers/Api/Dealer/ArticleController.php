<?php

namespace App\Http\Controllers\Api\Dealer;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleStoreRequest;
use App\Http\Requests\ArticleUpdateRequest;
use App\models\Article;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subsidiary = 1;
        return Article::with([
            'provider:providers.id,providers.name',
            'offer:offers.id,offers.name,offers.discount',
            'category:categories.id,categories.name',
            'shelf:shelves.id,shelves.name',
            'subsidiary' => function ($query) use ($subsidiary) {
                $query->select('subsidiaries.id', 'subsidiaries.name as subsidiary');
                //->where('subsidiaries.id',$subsidiary);
            },
        ])->get();
    }

    /**
     * Display a listing of the resource by subsidiary.
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function indexbysubsidiary($id)
    {
        return DB::table('articles')
            ->join('categories', 'articles.category_id', '=', 'categories.id')
            ->join('providers', 'articles.provider_id', '=', 'providers.id')
            ->leftjoin('offers', 'articles.offer_id', '=', 'offers.id')
            ->join('shelves', 'articles.shelf_id', '=', 'shelves.id')
            ->join('subsidiaries', 'shelves.subsidiary_id', '=', 'subsidiaries.id')
            ->select(
                'articles.*',
                'categories.name as category',
                'providers.name as provider',
                'offers.name as offer',
                'shelves.name as shelf',
                'subsidiaries.name as subsidiary',
                'subsidiaries.id as subsidiary_id',
            )
            ->where('subsidiaries.id', $id)
            ->orderBy('subsidiary')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleStoreRequest $request)
    {
        //Imagen Procesed
        $photo = request()->file('file');
        $photoUrl = $photo->store('public/img');
        $mirrorUrl = Storage::url($photoUrl);
        //Article Processed
        $user = auth('admin')->user();
        $userValided = Admin::find($user['id']);
        $userValided->articles()->create([
            'category_id'    => $request['category_id'],
            'shelf_id'       => $request['shelf_id'],
            'provider_id'    => $request['provider_id'],
            'offer_id'       => $request['offer_id'],
            'name'           => $request['name'],
            'purchaseprice'  => (float) $request['purchaseprice'],
            'saleprice'      => (float) $request['saleprice'],
            'description'    => $request['description'],
            'file'           => $mirrorUrl,
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
    public function update(ArticleUpdateRequest $request, Article $article)
    {
        if ($request->hasFile('file')) {
            Storage::delete($article['file']);
            //Imagen Procesed
            $photo = request()->file('file');
            $photoUrl = $photo->store('public/img');
            $mirrorUrl = Storage::url($photoUrl);
            //Article Processed
            $article->update([
                'category_id'    => $request['category_id'],
                'shelf_id'       => $request['shelf_id'],
                'provider_id'    => $request['provider_id'],
                'offer_id'       => $request['offer_id'],
                'name'           => $request['name'],
                'purchaseprice'  => (float) $request['purchaseprice'],
                'saleprice'      => (float) $request['saleprice'],
                'description'    => $request['description'],
                'file'           => $mirrorUrl,
            ]);
        } else {
            $article->update([
                'category_id'    => $request['category_id'],
                'shelf_id'       => $request['shelf_id'],
                'provider_id'    => $request['provider_id'],
                'offer_id'       => $request['offer_id'],
                'name'           => $request['name'],
                'purchaseprice'  => (float) $request['purchaseprice'],
                'saleprice'      => (float) $request['saleprice'],
                'description'    => $request['description'],
            ]);
        }


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
        Article::findOrFail($id)->delete();
        return ['status' => '200', 'message' => 'Eliminado con exito'];
    }
}
