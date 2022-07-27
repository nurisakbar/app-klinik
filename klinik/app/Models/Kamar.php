<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    protected $table = 'kamar';
    protected $fillable = ['kode_kamar', 'nama_kamar', 'kelas'];
}
