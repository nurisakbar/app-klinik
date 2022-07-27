<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = "setting";

    protected $fillable = ['nama_instansi','email','nomor_telpon','alamat','logo'];
}
