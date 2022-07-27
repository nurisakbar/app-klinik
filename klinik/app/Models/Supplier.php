<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'supplier';

    protected $fillable = ['nama_supplier', 'nomor_telpon', 'alamat'];
}
