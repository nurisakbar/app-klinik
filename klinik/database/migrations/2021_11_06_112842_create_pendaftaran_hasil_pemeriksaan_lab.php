<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendaftaranHasilPemeriksaanLab extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pendaftaran_hasil_pemeriksaan_lab', function (Blueprint $table) {
            $table->id();
            $table->integer('pendaftaran_id');
            $table->integer('indikator_pemeriksaan_lab_id');
            $table->string('hasil')->nullable();
            $table->string('catatan')->nullable();
            $table->string('analis_laboratorium')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pendaftaran_hasil_pemeriksaan_lab');
    }
}
