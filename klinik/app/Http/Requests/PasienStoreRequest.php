<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasienStoreRequest extends FormRequest
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
            'nama'              =>  'required',
            'nomor_ktp'         =>  'required',
            'nomor_hp'          =>  'required',
            'tanggal_lahir'     =>  'required',
            'tempat_lahir'      =>  'required',
            'alamat'            =>  'required',
            'rt_rw'             =>  'required',
            'agama'             =>  'required',
            'pekerjaan'         =>  'required',
            'pendidikan'        =>  'required',
            'nama_ibu'          =>  'required',
            'wilayah_administratif' => 'required',
            'penanggung_jawab'  =>  'required',
            'alamat_penanggung_jawab'  =>  'required',
            'nomor_hp_penanggung_jawab'  =>  'required',
        ];
    }
}
