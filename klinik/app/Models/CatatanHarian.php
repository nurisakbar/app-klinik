<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatatanHarian extends Model
{
    protected $table = "catatan_harian";

    protected $fillable = ['pendaftaran_id','tanggal','catatan'];
}
