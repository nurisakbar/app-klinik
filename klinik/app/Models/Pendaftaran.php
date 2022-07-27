<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    protected $table = "pendaftaran";

    protected $fillable = [
        'kode',
        'pasien_id',
        'perusahaan_asuransi_id',
        'status_pembayaran',
        'status_pelayanan',
        'status_alergi',
        'tanda_tanda_vital',
        'jenis_pendaftaran',
        'jenis_rujukan',
        'nama_perujuk',
        'no_surat',
        'tanggal_berlaku',
        'penanggung_jawab',
        'hubungan_pasien',
        'alamat_penanggung_jawab',
        'no_hp_penanggung_jawab',
        'pemeriksaan_klinis',
        'anamnesa',
    ];

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

    public function perusahaanAsuransi()
    {
        return $this->belongsTo('App\Models\PerusahaanAsuransi', 'perusahaan_asuransi_id', 'id');
    }

    public function userKasir()
    {
        return $this->belongsTo('App\User', 'user_id_kasir', 'id');
    }

    public function getTandaTandaVitalAttribute($value)
    {
        return unserialize($value);
    }

    public function getPemeriksaanKlinisAttribute($value)
    {
        return unserialize($value);
    }

    public function feeTindakan()
    {
        return $this->hasMany('App\Models\PendaftaranTindakan');
    }

    public function obatRacik()
    {
        return $this->hasMany('App\Models\PendaftaranObatRacik');
    }

    public function resepNonRacik()
    {
        return $this->hasMany('App\Models\PendaftaranResep')->where('jenis', 'non racik');
    }

    public function resepBhp()
    {
        return $this->hasMany('App\Models\PendaftaranResep')->where('jenis', 'bhp');
    }

    public function tindakan()
    {
        return $this->belongsTo('App\Models\Tindakan', 'tindakan_id', 'id');
    }

    public function jenisLayanan()
    {
        return $this->belongsTo('App\Models\PerusahaanAsuransi', 'jenis_layanan', 'id');
    }


    public function nomorAntrian()
    {
        return $this->hasMany('App\Models\NomorAntrian', 'pendaftaran_id', 'id');
    }
}
