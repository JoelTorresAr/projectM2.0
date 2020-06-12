<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffUpdateRequest extends FormRequest
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
            'subsidiary_id'     => ['required','integer'],
            'workposition_id'   => ['required','integer'],
            'district_id'       => ['required','integer'],
            'address'           => ['required','string'],
            'name'              => ['required','string'],
            'lastname'          => ['required','string'],
            'phone'             => ['required'],
            'email'             => ['required','email'],
            'birthday'          => ['required','date'],
        ];
    }
}
