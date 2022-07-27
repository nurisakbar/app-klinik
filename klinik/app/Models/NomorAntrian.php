<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class NomorAntrian extends Model
{
    protected $table = "nomor_antrian";

    protected $fillable = [
        'pendaftaran_id',
        'poliklinik_id',
        'nomor_antrian',
        'dokter_id',
        'anamnesa',
        'status_pelayanan',
        'sudah_dipanggil',
        'status_pembayaran',
        'metode_pembayaran',
        'keterangan_pembayaran',
        'jumlah_bayar',
        'total_bayar',
        'biaya_tambahan',
        'user_id_kasir',
        'perusahaan_asuransi_id',
        'durasi_pelayanan'
    ];


    public function poliklinik()
    {
        return $this->belongsTo(Poliklinik::class, 'poliklinik_id', 'id');
    }

    public function dokter()
    {
        return $this->belongsTo(User::class, 'dokter_id', 'id');
    }

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'pendaftaran_id', 'id');
    }
    public function tindakan()
    {
        return $this->belongsTo('App\Models\Tindakan', 'tindakan_id', 'id');
    }

    public function perusahaanAsuransi()
    {
        return $this->belongsTo('App\Models\PerusahaanAsuransi', 'perusahaan_asuransi_id', 'id');
    }
}
