<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendaftaranTindakan extends Model
{
    protected $table = "pendaftaran_tindakan";

    protected $fillable = ['tindakan_id', 'pendaftaran_id','poliklinik_id', 'fee', 'anamnesa', 'kode_gigi', 'tbm_icd_id','qty','discount','poliklinik_id','pemeriksaan_klinis'];

    public function pendaftaran()
    {
        return $this->belongsTo('App\Models\Pendaftaran');
    }

    public function tindakan()
    {
        return $this->belongsTo('App\Models\Tindakan');
    }


    public function tbm()
    {
        return $this->belongsTo(TbmIcd::class, 'tbm_icd_id', 'id');
    }

    public function hasilPemeriksaan()
    {
        return $this->hasMany('App\Models\HasilPemeriksaanLab');
    }
}
