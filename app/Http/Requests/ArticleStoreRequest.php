<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'file'          => ['required','mimes:jpeg,png'],
            'category_id'   => ['required','integer'],
            'shelf_id'      => ['required','integer'],
            'provider_id'   => ['required','integer'],
            'name'          => ['required','string'],
            'purchaseprice' => ['required','numeric','min:0'],
            'saleprice'     => ['required','numeric','min:0'],
            'description'   => ['required','string','max:120'],
        ];
    }
}
