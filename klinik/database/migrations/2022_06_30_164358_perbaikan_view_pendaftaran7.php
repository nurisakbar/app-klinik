<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PerbaikanViewPendaftaran7 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement("DROP VIEW IF EXISTS view_pendaftaran");
        \DB::statement("create view view_pendaftaran as select na.pendaftaran_id,
		na.created_at,
        na.metode_pembayaran,
        na.perusahaan_asuransi_id,
        na.id,pa.nomor_rekam_medis,
        pa.nama,na.nomor_antrian,
        left(na.created_at,10)as tanggal,
        po.nama as nama_poliklinik,
        po.id as poliklinik_id,
        u.name as nama_dokter,
        pas.nama_perusahaan,
        na.status_pelayanan,
        na.sudah_dipanggil,
        na.status_pembayaran,
        na.total_bayar,
        na.jumlah_bayar,
        na.biaya_tambahan,
        p.kode,
        uk.name as nama_kasir
        from nomor_antrian as na left join pendaftaran as p on na.pendaftaran_id=p.id
        left join pasien as pa on pa.id=p.pasien_id
        left join poliklinik as po on po.id=na.poliklinik_id
        left JOIN users as u on u.id=na.dokter_id
        left join perusahaan_asuransi as pas on pas.id=na.perusahaan_asuransi_id
        join users as uk on uk.id=na.user_id_kasir");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
