<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaketIterasi extends Model
{
    protected $table = 'paket_iterasi';

    protected $fillable = ['pasien_id','tindakan_id','quota'];


    public function tindakan()
    {
        return $this->belongsTo('App\Models\Tindakan');
    }
}
