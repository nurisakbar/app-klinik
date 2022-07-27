<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermintaanBarangInternalDetail extends Model
{
    protected $table = 'permintaan_barang_internal_detail';

    protected $fillable = ['barang_id', 'jumlah_diminta', 'jumlah_diterima', 'permintaan_barang_internal_id'];

    public function barang()
    {
        return $this->belongsTo('App\Models\Barang', 'barang_id', 'id');
    }

    public function permintaan_barang_internal()
    {
        return $this->belongsTo('App\Models\PermintaanBarangInternal');
    }
}
