<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendaftaranDiagnosa extends Model
{
    protected $table = "pendaftaran_diagnosa";

    protected $fillable = ['tbm_icd_id','pendaftaran_id','poliklinik_id'];

    public function pendaftaran()
    {
        return $this->belongsTo('App\Models\Pendaftaran');
    }

    public function icd()
    {
        return $this->belongsTo('App\Models\Icd', 'tbm_icd_id');
    }
}
