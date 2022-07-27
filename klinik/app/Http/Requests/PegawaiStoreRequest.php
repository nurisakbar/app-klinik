<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PegawaiStoreRequest extends FormRequest
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
            'nama'          =>  'required',
            'nip'           =>  'required|min:16|numeric',
            'tanggal_lahir' =>  'required',
            'tempat_lahir'  =>  'required',
            'alamat'        =>  'required',
            'no_hp'         =>  'required',
            'gaji_pokok'    =>  'required',
            'tanggal_masuk' =>  'required',
            'tunjangan_kehadiran' =>  'required',
            'nama_bank'           =>  'required',
            'nomor_rekening'      =>  'required',
        ];
    }
}
