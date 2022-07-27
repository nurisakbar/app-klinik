<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Akun;

class Jurnal extends Model
{
    protected $table = "jurnal";

    protected $fillable = ['tanggal', 'nominal', 'akun_id', 'keterangan', 'tipe', 'periode','user_id'];

    public function akun()
    {
        return $this->belongsTo(Akun::class);
    }
}
