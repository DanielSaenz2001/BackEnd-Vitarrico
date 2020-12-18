<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignUpRequest extends FormRequest
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
            'name' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            //'email' => 'required|email|unique:users|not_regex:/[a-zA-Z0-9._%+-]+@[u]+\.[p]+\.[e]+\.[u]+\.[e]+\.[d]+\.[u]+\.[p]+\.[e]/',
            'password' => 'required|confirmed',
            'rol' =>'required',
            'area' =>'required',
            'autorizado'=>'required'
            //'personaid' => 'required',
        ];
    }
}
