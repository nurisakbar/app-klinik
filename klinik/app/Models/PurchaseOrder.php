<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $table = 'purchase_order';

    protected $fillable = ['kode', 'tanggal', 'supplier_id','status_po', 'alasan','diskon'];

    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier', 'supplier_id', 'id');
    }

    public function detail()
    {
        return $this->hasMany('App\Models\PurchaseOrderDetail', 'purchase_order_id');
    }
}
