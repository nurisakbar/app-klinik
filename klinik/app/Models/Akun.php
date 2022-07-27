<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Akun extends Model
{
    protected $table = "akun";

    protected $fillable = ['kode', 'nama'];

    public function jurnal()
    {
        return $this->hasMany(Jurnal::class);
    }
}
