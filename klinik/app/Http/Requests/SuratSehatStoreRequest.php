<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuratSehatStoreRequest extends FormRequest
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
            'keperluan'          => 'required',
            'tanggal_mulai'      => 'required',
            'keperluan'          => 'required',
            'tekanan_darah'      => 'required',
            'tinggi_badan'       => 'required',
            'berat_badan'        => 'required'
        ];
    }
}
