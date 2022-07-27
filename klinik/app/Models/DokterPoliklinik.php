<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokterPoliklinik extends Model
{
    protected $table = "dokter_poliklinik";

    protected $fillable = ['user_id', 'poliklinik_id'];


    public function poliklinik()
    {
        return $this->belongsTo(\App\Models\Poliklinik::class);
    }
}
