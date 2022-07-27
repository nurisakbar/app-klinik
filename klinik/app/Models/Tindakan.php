<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tindakan extends Model
{
    protected $table = "tindakan";

    protected $fillable = ['kode','tindakan','tarif_umum','tarif_bpjs','tarif_perusahaan','pembagian_tarif', 'jenis','iterasi','quota','pelayanan','poliklinik_id'];

    public function getPembagianTarifAttribute($value)
    {
        return unserialize($value);
    }

    public function icd()
    {
        return $this->belongsTo('App\Models\TbmIcdNine', 'kode');
    }

    public function indikator()
    {
        return $this->hasMany('App\Models\IndikatorPemeriksaanLab', 'tindakan_id');
    }

    public function bhp()
    {
        return $this->hasMany('App\Models\TindakanBHP');
    }
    public function poliklinik()
    {
        return $this->belongsTo('App\Models\Poliklinik');
    }
}
