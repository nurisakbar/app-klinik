<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndikatorPemeriksaanLab extends Model
{
    protected $table = "indikator_pemeriksaan_laboratorium";

    protected $fillable = [ 'nama_indikator', 'satuan', 'nilai_rujukan', 'tindakan_id', 'pendaftaran_id'];

    public function tindakan()
    {
        return $this->belongsTo('App\Models\JenisPemeriksaanLabController', 'tindakan_id');
    }
}
