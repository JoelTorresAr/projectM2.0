<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleUpdateRequest extends FormRequest
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
                'file'          => ['nullable'],
                'category_id'   => ['required','integer'],
                'shelf_id'      => ['required','integer'],
                'provider_id'   => ['nullable'],
                'name'          => ['required','string'],
                'stock'         => ['required','integer'],
                'purchaseprice' => ['required','numeric','min:0'],
                'saleprice'     => ['required','numeric','min:0'],
                'description'   => ['required','string','max:120'],
        ];
    }
}
