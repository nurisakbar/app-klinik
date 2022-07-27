<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserStoreRequest extends FormRequest
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
            'name'          =>  'required',
            'email'         =>  'required|email|unique:users',
            'password'      =>  'required',
            'role'          =>  'required',
            'poliklinik_id' => 'required_if:role,==,dokter',
            'spesialis'     => 'required_if:role,==,dokter'
        ];
    }
}
