<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bed extends Model
{
    protected $table = 'bed';
    protected $fillable = ['kamar_id', 'kode_bed', 'tarif', 'status'];

    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
    }
}
