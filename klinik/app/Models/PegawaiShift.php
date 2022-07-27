<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PegawaiShift extends Model
{
    protected $table = 'pegawai_shift';
    protected $fillable = ['tanggal', 'pegawai_id', 'shift_id'];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }
}
