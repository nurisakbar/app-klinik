<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnitStock extends Model
{
    protected $table = "unit_stock";

    protected $fillable = ['nama_unit'];

    public function barang()
    {
        return $this->belongsTo('App\Models\Barang');
    }
}
