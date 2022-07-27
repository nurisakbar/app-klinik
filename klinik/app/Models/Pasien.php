<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    protected $table = "pasien";

    protected $fillable = [
        'nomor_ktp',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'nomor_hp',
        'pekerjaan',
        'alamat',
        'rt_rw',
        'jenis_kelamin',
        'pendidikan',
        'agama',
        'status_pernikahan',
        'nama_ibu',
        'nomor_asuransi',
        'kewarganegaraan',
        'golongan_darah',
        'privilage_khusus',
        'penanggung_jawab',
        'suku_bangsa',
        'hubungan_pasien',
        'alamat_penanggung_jawab',
        'nomor_hp_penanggung_jawab',
        'nomor_rekam_medis',
        'penjamin',
        'village_id',
        'province_id',
        'district_id',
        'regency_id',
        'inisial',
        'foto'
    ];


    public function wilayahAdministratifIndonesia()
    {
        return $this->belongsTo('App\Models\WilayahAdministratifIndonesia', 'village_id', 'village_id');
    }

    public function rujukan(Type $var = null)
    {
        return $this->hasMany('App\Models\RujukanInternal');
    }

    public function riwayatPenyakit()
    {
        return $this->hasMany('App\Models\RiwayatPenyakit', 'pasien_id', 'id')->where('tbm_icd', '!=', '');
    }

    public function paketIterasi()
    {
        return $this->hasMany('App\Models\PaketIterasi');
    }

    protected $appends = ['umur'];

    public function getUmurAttribute()
    {
        $tanggal_lahir  = new \DateTime($this->tanggal_lahir);
        $now            = new \DateTime();
        $umur           = $now->diff($tanggal_lahir);
        return $this->tanggal_lahir == '0000-00-00' ? '0' : $umur->y;
    }
}
