<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermintaanBarangInternal extends Model
{
    protected $table = 'permintaan_barang_internal';

    protected $fillable = ['unit_stock_id_sumber', 'unit_stock_id_tujuan', 'tanggal'];

    public function unitSumber()
    {
        return $this->belongsTo('App\Models\UnitStock', 'unit_stock_id_sumber');
    }

    public function unitTujuan()
    {
        return $this->belongsTo('App\Models\UnitStock', 'unit_stock_id_tujuan');
    }

    public function detail()
    {
        return $this->hasMany('App\Models\PermintaanBarangInternalDetail', 'permintaan_barang_internal_id');
    }
}
