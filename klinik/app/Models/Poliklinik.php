<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Poliklinik extends Model
{
    protected $table = "poliklinik";

    protected $fillable = ['nomor_poli','nama','keterangan','aktif','jenis_unit','unit_stock_id'];

    public function unitStock()
    {
        return $this->belongsTo('App\Models\UnitStock')->withDefault(['nama_unit' => 'Belum Terhubung']);
    }



    public function scopeKunjunganPasienPerPoli($query, $tanggal_awal, $tanggal_akhir, $perusahaan_asuransi)
    {
        return $query->leftJoin('nomor_antrian', function ($join) use ($tanggal_awal, $tanggal_akhir, $perusahaan_asuransi) {
            $join->on('nomor_antrian.poliklinik_id', '=', 'poliklinik.id');
            $join->whereBetween(DB::raw('DATE(nomor_antrian.created_at)'), [$tanggal_awal,$tanggal_akhir]);
            if ($perusahaan_asuransi != 0) {
                $join->on('pendaftaran.id', '', 'nomor_antrian.pendaftaran_id');
                $join->where('pendaftaran.layanan', $perusahaan_asuransi);
            }
        })
        ->selectRaw('poliklinik.nama,poliklinik.nomor_poli, count(nomor_antrian.id) as jumlah_kunjungan')
        ->groupBy('poliklinik.id');
    }
}
