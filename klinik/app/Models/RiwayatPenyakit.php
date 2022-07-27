<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatPenyakit extends Model
{
    protected $table = "pendaftaran_riwayat_penyakit";

    protected $fillable = ['tbm_icd','pendaftaran_id','pasien_id'];

    public function pendaftaran()
    {
        return $this->belongsTo('App\Models\Pendaftaran');
    }

    public function tbmIcd()
    {
        return $this->belongsTo('App\Models\TbmIcd', 'tbm_icd');
    }
}
