<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendaftaranObatRacik extends Model
{
    protected $table = 'pendaftaran_obat_racik';

    protected $fillable = ['pendaftaran_id','aturan_pakai','kemasan','jumlah_kemasan','poliklinik_id'];



    public function detail()
    {
        return $this->hasMany(\App\Models\PendaftaranObatRacikDetail::class);
    }

    public function satuan()
    {
        return $this->belongsTo(\App\Models\Satuan::class, 'kemasan', 'id');
    }
}
