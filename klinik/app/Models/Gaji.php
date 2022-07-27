<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    protected $table = "gaji";

    protected $fillable = ['pegawai_id', 'periode', 'status_bayar', 'approval', 'take_home_pay'];

    public function pegawai()
    {
        return $this->belongsTo(\App\Models\Pegawai::class);
    }

    public function komponen_gaji()
    {
        return $this->belongsTo(KomponenGaji::class);
    }

    public function detail()
    {
        return $this->hasMany("App\Models\GajiDetail");
    }
}
