<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusPembayaran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nomor_antrian', function (Blueprint $table) {
            $table->boolean('status_pembayaran')->default(0);
            $table->string('metode_pembayaran')->nullable()->default(null);
            $table->string('keterangan_pembayaran')->nullable()->default(null);
            $table->integer('jumlah_bayar');
            $table->integer('total_bayar');
            $table->dropColumn('tindakan_id');
            $table->integer('user_id_kasir');
            $table->integer('perusahaan_asuransi_id');
            $table->string('status_pelayanan');
        });

        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->dropColumn('status_pembayaran');
            $table->integer('perusahaan_asuransi_id');
            $table->dropColumn('status_pelayanan');
            $table->dropColumn('metode_pembayaran');
            $table->dropColumn('jumlah_bayar');
            $table->dropColumn('biaya_tambahan');
            $table->dropColumn('total_bayar');
            $table->dropColumn('user_id_kasir');
            $table->dropColumn('keterangan_pembayaran');
            $table->dropColumn('tindakan_id');
            $table->dropColumn('jenis_layanan');
            $table->dropColumn('check_list_poli_kebidanan');

        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nomor_antrian', function (Blueprint $table) {
            //
        });
    }
}
