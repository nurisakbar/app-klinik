<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsInPendaftaran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->string('jenis_pendaftaran');
            $table->string('jenis_rujukan');
            $table->string('nama_perujuk')->nullable();
            $table->string('penjamin');
            $table->string('no_surat')->nullable();
            $table->date('tanggal_berlaku')->nullable();
            $table->string('penanggung_jawab');
            $table->string('hubungan_pasien');
            $table->string('alamat_penanggung_jawab');
            $table->string('no_telp_penanggung_jawab');
            $table->string('no_hp_penanggung_jawab');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
            //
        });
    }
}
