<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TbmIcd extends Model
{
    protected $table = "tbm_icd";

    protected $fillable = ['kode','indonesia','id'];
}
