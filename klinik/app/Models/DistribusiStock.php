<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DistribusiStock extends Model
{
    protected $table = "distribusi_stock";

    protected $fillable = ['id','unit_stock_id','barang_id','jumlah_stock','poliklinik_id'];

    public function barang()
    {
        return $this->belongsTo('App\Models\Barang');
    }

    public function unitStock()
    {
        return $this->belongsTo('App\Models\UnitStock', 'unit_stock_id');
    }
}
