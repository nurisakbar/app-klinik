<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RujukanInternal extends Model
{
    protected $table = "rujukan_internal";

    protected $fillable = ['users_id', 'pasien_id', 'poliklinik_id', 'tindakan_id','pendaftaran_id','catatan','status'];

    public function dokter()
    {
        return $this->belongsTo('App\User', 'users_id');
    }

    public function pasien()
    {
        return $this->belongsTo('App\Models\Pasien');
    }

    public function poliklinik()
    {
        return $this->belongsTo('App\Models\Poliklinik');
    }

    public function tindakan()
    {
        return $this->belongsTo('App\Models\Tindakan', 'tindakan_id');
    }
}
