<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TindakanStoreRequest extends FormRequest
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
            //'kode'              =>  'required',
            'tindakan'          =>  'required',
            'tarif_umum'        =>  'required|integer',
            'tarif_bpjs'        =>  'required|integer',
            'tarif_perusahaan'  =>  'required|integer',
            'tarif_bpjs'        =>  'required|integer',
            'pembagian_tarif'   =>  'required',
        ];
    }
}
