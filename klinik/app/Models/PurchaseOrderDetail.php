<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderDetail extends Model
{
    protected $table = 'purchase_order_detail';

    protected $fillable = ['barang_id', 'qty', 'harga', 'purchase_order_id', 'qty_diterima','approval','catatan','diskon','satuan_id'];

    public function barang()
    {
        return $this->belongsTo('App\Models\Barang', 'barang_id', 'id');
    }

    public function satuan()
    {
        return $this->belongsTo(\App\Models\Satuan::class, 'satuan_id', 'id');
    }
}
