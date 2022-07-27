<?php

namespace App\Models;

use App\Models\Pendaftaran;
use App\Models\TbmIcd;
use Illuminate\Database\Eloquent\Model;

class PendaftaranPemeriksaanGigi extends Model
{
    protected $table = "pendaftaran_pemeriksaan_gigi";
    protected $guarded = ["id"];

    public function tbm()
    {
        return $this->belongsTo(TbmIcd::class, 'tbm_icd_id', 'id');
    }

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }
}
