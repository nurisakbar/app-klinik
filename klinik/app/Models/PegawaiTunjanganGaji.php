<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PegawaiTunjanganGaji extends Model
{
    protected $table = "pegawai_tunjangan_gaji";

    protected $fillable = ['pegawai_id', 'komponen_gaji_id', 'jumlah', 'keterangan'];

    public function komponen_gaji()
    {
        return $this->belongsTo(KomponenGaji::class);
    }
}
