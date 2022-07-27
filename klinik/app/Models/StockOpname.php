<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockOpname extends Model
{
    protected $table = "stock_opname";

    public function barang()
    {
        return $this->belongsTo(\App\Models\Barang::class, 'kode_barang', 'kode');
    }
}
