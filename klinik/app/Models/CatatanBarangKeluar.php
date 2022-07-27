<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatatanBarangKeluar extends Model
{
    protected $table = 'catatan_barang_keluar';

    protected $fillable = ['barang_id','qty','perusahaan_penjamin_id','relation_id','harga_modal','harga_jual'];
}
