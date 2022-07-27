<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendaftaranTindakanTemp extends Model
{
    protected $table = 'pendaftaran_tindakan_temp';

    protected $fillable = ['perusahaan_asuransi_id','pasien_id','tindakan_id'];

    public function tindakan()
    {
        return $this->belongsTo('App\Models\Tindakan');
    }
}
