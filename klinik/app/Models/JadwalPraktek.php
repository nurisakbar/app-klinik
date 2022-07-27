<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class JadwalPraktek extends Model
{
    protected $table = 'jadwal_praktek';
    protected $fillable = ['user_id', 'hari', 'jam', 'poliklinik_id'];


    public function poliklinik()
    {
        return $this->belongsTo('App\Models\Poliklinik', 'poliklinik_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
