<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewPendaftaranFeeTindakansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement("DROP VIEW IF EXISTS view_pendafatran_fee_tindakan");
        \DB::statement("CREATE view view_pendaftaran_fee_tindakan as select `pendaftaran`.`created_at` as `tanggal`, `users`.`name` as `nama_pelaksana`, `pendaftaran_fee_tindakan`.`pelaksana`, `pendaftaran_fee_tindakan`.`jumlah_fee`, `pendaftaran`.`kode` as `nomor_pendaftaran`, `poliklinik`.`nama` as `unit`, `perusahaan_asuransi`.`nama_perusahaan` as `jenis_pelayanan`, `tindakan`.`tindakan` as `nama_tindakan` from `pendaftaran_fee_tindakan` inner join `nomor_antrian` on `nomor_antrian`.`pendaftaran_id` = `pendaftaran_fee_tindakan`.`pendaftaran_id` inner join `pendaftaran` on `pendaftaran`.`id` = `pendaftaran_fee_tindakan`.`pendaftaran_id` inner join `poliklinik` on `poliklinik`.`id` = `nomor_antrian`.`poliklinik_id` inner join `perusahaan_asuransi` on `perusahaan_asuransi`.`id` = `nomor_antrian`.`perusahaan_asuransi_id` inner join `tindakan` on `tindakan`.`id` = `pendaftaran_fee_tindakan`.`tindakan_id` inner join `users` on `users`.`id` = `pendaftaran_fee_tindakan`.`user_id` where left(nomor_antrian.created_at,10)");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('view_pendaftaran_fee_tindakans');
    }
}
