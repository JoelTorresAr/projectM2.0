<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotosController extends Controller
{
    public function storeArticle(Request $request){
        $this->validate(request(),[
            'file' => 'required|image'
        ]);
        $photo = request()->file('file');
        $photoUrl = $photo->store('public');

        return Storage::url($photoUrl);
    }
}
