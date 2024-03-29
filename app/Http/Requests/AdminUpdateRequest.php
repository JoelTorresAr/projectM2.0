<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminUpdateRequest extends FormRequest
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
        return  [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email','max:120', 'unique:admins,email,'.$this->admin],
            'password' => ['confirmed'],
            'description' => ['required', 'string', 'max:255'],
        ];
    }
}
