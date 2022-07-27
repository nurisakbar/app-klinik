<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $table = "pegawai";
    protected $fillable = [
        'nama',
        'nip',
        'tempat_lahir',
        'tanggal_lahir',
        'kelompok_pegawai_id',
        'agama', 'jenis_kelamin',
        'alamat',
        'no_hp',
        'gaji_pokok',
        'user_id',
        'tanggal_masuk',
        'tanggal_keluar',
        'tunjangan_kehadiran',
        'nama_bank',
        'nomor_rekening',
    ];

    public function kelompok_pegawai()
    {
        return $this->belongsTo(KelompokPegawai::class);
    }
}
