<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KomponenGaji extends Model
{
    protected $table = 'komponen_gaji';

    protected $fillable = ['nama_komponen','keterangan','jumlah','jenis'];
}
