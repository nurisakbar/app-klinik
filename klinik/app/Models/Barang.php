<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang extends Model
{
    use SoftDeletes;

    protected $table = 'barang';


    protected $fillable = [
        'nama_barang',
        'kode',
        'jenis',
        'aktif',
        'harga',
        'keterangan',
        'jenis_barang',
        'kategori_id',
        'satuan_terbesar_id',
        'satuan_terkecil_id',
        'margin',
        'pelayanan',
        'pbf_id',
        'jenis_barang_kedua',
        'jumlah_satuan_terbesar',
        'jumlah_satuan_terkecil'
    ];

    public function satuanTerbesar()
    {
        return $this->belongsTo(\App\Models\Satuan::class, 'satuan_terbesar_id', 'id');
    }

    public function satuanTerkecil()
    {
        return $this->belongsTo(\App\Models\Satuan::class, 'satuan_terkecil_id', 'id');
    }

    public function kategori()
    {
        return $this->belongsTo(\App\Models\Kategori::class);
    }

    public function pbf()
    {
        return $this->belongsTo(\App\Models\PedagangBesarFarmasi::class);
    }

    protected $appends = ['harga_jual'];

    public function getHargaJualAttribute()
    {
        $harga_ppn = $this->harga + ($this->harga * 0.11); /// harga + ppn 10%
        $harga_ppn_margin = $harga_ppn * ($this->margin / 100); // harga ppn * margin
        return $harga_ppn + $harga_ppn_margin;
    }
}
