<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PerbaikanViewLaporanTindakan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement("DROP VIEW IF EXISTS view_laporan_pendaftaran_tindakan");
        \DB::select("create view view_laporan_pendaftaran_tindakan as 
        select cast(na.created_at as date) as tanggal,
        p.nomor_rekam_medis,
        p.nama as nama_pasien,
        na.perusahaan_asuransi_id,
        pa.nama_perusahaan as perusahaan_asuransi,
        t.tindakan as nama_tindakan,
        pk.nama as poliklinik,
        pt.fee as biaya_tindakan,pt.qty,pt.discount,
        (pt.fee-pt.discount)*pt.qty as tarif_total
        from nomor_antrian as na
        join pendaftaran as pd on pd.id=na.pendaftaran_id
        join pendaftaran_tindakan as pt on na.pendaftaran_id=pt.pendaftaran_id
        join pasien as p on p.id=pd.pasien_id
        join poliklinik as pk on pk.id=na.poliklinik_id
        join perusahaan_asuransi as pa on pa.id=na.perusahaan_asuransi_id
        join tindakan as t on t.id=pt.tindakan_id;");
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
