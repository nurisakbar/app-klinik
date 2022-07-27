<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KehadiranPegawai extends Model
{
    protected $table = 'kehadiran_pegawai';
    protected $guarded = [];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }
}
