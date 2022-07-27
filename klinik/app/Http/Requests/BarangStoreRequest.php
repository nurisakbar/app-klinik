<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BarangStoreRequest extends FormRequest
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
            'nama_barang'           =>  'required',
            'harga'                 =>  'required|integer',
            'satuan_terbesar_id'    =>  'required',
            'kategori_id'           =>  'required',
            'satuan_terkecil_id'    =>  'required',
            'jenis_barang'          =>  'required',
            'aktif'                 =>  'required',
            'jumlah_satuan_terbesar' =>  'required',
            'jumlah_satuan_terkecil' =>  'required'
        ];
    }
}
