<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GajiDetail extends Model
{
    protected $table = "gaji_detail";

    protected $fillable = ['gaji_id', 'komponen_gaji_id', 'jumlah', 'pegawai_id'];

    public function komponen_gaji()
    {
        return $this->belongsTo(KomponenGaji::class);
    }

    public function gaji()
    {
        return $this->belongsTo(Gaji::class);
    }
}
