<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TindakanBHP extends Model
{
    protected $table = "tindakan_bhp";

    protected $fillable = ['barang_id','tindakan_id','jumlah','satuan_id'];

    public function barang()
    {
        return $this->belongsTo('App\Models\Barang');
    }

    public function tindakan()
    {
        return $this->belongsTo('App\Models\Tindakan');
    }

    public function satuan()
    {
        return $this->belongsTo('App\Models\Satuan');
    }
}
