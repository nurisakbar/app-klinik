<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TambahColumnPasien extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pasien', function (Blueprint $table) {
            $table->string('nomor_rekam_medis');
            $table->string('nomor_asuransi')->nullable();
            $table->string('penjamin');
            $table->string('kewarganegaraan');
            $table->string('golongan_darah');
            $table->string('suku_bangsa')->nullable();
            $table->string('privilage_khusus');
            $table->string('penanggung_jawab');
            $table->string('hubungan_pasien');
            $table->string('alamat_penanggung_jawab');
            $table->string('no_telp_penanggung_jawab');
            $table->foreignId('province_id')->nullable();
            $table->foreignId('regency_id')->nullable();
            $table->foreignId('district_id')->nullable();
            $table->foreignId('village_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pasien', function (Blueprint $table) {
            //
        });
    }
}
