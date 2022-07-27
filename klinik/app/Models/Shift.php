<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    protected $table = 'shift';

    protected $fillable = [
        'nama_shift', 'jam_masuk',
        'jam_pulang',
        'toleransi_terlambat_masuk',
        'toleransi_terlambat_pulang'
    ];
}
