<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotosController extends Controller
{
    public function storeArticle(Request $request){
        DD($request['maxFilesize']);
        $this->validate(request(),[
            'file' => 'required|image'
        ]);
        $photo = request()->file('file');
        $photoUrl = $photo->store('public/img');

        return Storage::url($photoUrl);
    }
}
