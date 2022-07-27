<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pendaftaran_fee_tindakan', function (Blueprint $table) {
            $table->index('tindakan_id');
            $table->index('pendaftaran_id');
            $table->index('poliklinik_id');
            $table->index('user_id');
        });

        Schema::table('pendaftaran_tindakan', function (Blueprint $table) {
            $table->index('tindakan_id');
            $table->index('pendaftaran_id');
            $table->index('poliklinik_id');
        });

        Schema::table('pendaftaran_diagnosa', function (Blueprint $table) {
            $table->index('pendaftaran_id');
            $table->index('poliklinik_id');
            $table->index('tbm_icd_id');
        });

        Schema::table('pendaftaran_obat_racik', function (Blueprint $table) {
            $table->index('pendaftaran_id');
            $table->index('poliklinik_id');
        });

        Schema::table('pendaftaran_obat_racik_detail', function (Blueprint $table) {
            $table->index('pendaftaran_obat_racik_id');
            $table->index('barang_id');
        });

        Schema::table('pendaftaran_resep', function (Blueprint $table) {
            $table->index('pendaftaran_id');
            $table->index('barang_id');
            $table->index('satuan_terkecil_id');
            $table->index('poliklinik_id');
        });

        Schema::table('nomor_antrian', function (Blueprint $table) {
            $table->index('pendaftaran_id');
            $table->index('dokter_id');
            $table->index('user_id_kasir');
            $table->index('poliklinik_id');
            $table->index('perusahaan_asuransi_id');
        });

        Schema::table('distribusi_stock', function (Blueprint $table) {
            $table->index('barang_id');
            $table->index('unit_stock_id');
        });

        Schema::table('catatan_barang_keluar', function (Blueprint $table) {
            $table->index('barang_id');
            $table->index('perusahaan_penjamin_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fee', function (Blueprint $table) {
            //
        });
    }
}
