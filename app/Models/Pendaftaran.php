<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    protected $table = "pendaftaran";

    protected $fillable = ['kode', 'pasien_id', 'dokter_id', 'jenis_layanan', 'status_pembayaran', 'poliklinik_id', 'tanda_tanda_vital', 'jenis_pendaftaran', 'jenis_rujukan', 'nama_perujuk', 'penjamin', 'no_surat', 'tanggal_berlaku', 'penanggung_jawab', 'hubungan_pasien', 'alamat_penanggung_jawab', 'no_telp_penanggung_jawab', 'no_hp_penanggung_jawab'];

    public function pasien()
    {
        return $this->belongsTo('App\Models\Pasien', 'pasien_id', 'id');
    }

    public function poliklinik()
    {
        return $this->belongsTo('App\Models\Poliklinik', 'poliklinik_id', 'id');
    }

    public function dokter()
    {
        return $this->belongsTo('App\User', 'dokter_id', 'id');
    }

    public function getTandaTandaVitalAttribute($value)
    {
        return unserialize($value);
    }
}
