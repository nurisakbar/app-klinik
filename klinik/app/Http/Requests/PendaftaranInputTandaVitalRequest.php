<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PendaftaranInputTandaVitalRequest extends FormRequest
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
            'berat_badan'      =>  'required',
            'tekanan_darah'    =>  'required',
            'suhu_tubuh'       =>  'required',
            'tinggi_badan'     =>  'required',
            'nadi'             =>  'required',
            'rr'               =>  'required',
            'saturasi_o2'      =>  'required',
            'saturasi_o2'      =>  'required',
            'fungsi_penciuman' =>  'required',
            'jenis_kasus'      =>  'required',
        ];
    }
}
