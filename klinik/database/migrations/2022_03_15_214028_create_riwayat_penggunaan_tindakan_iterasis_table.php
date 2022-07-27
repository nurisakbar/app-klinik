<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiwayatPenggunaanTindakanIterasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('riwayat_penggunaan_tindakan_iterasi', function (Blueprint $table) {
            $table->id();
            $table->integer('pendaftaran_id');
            $table->integer('paket_iterasi_id');
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
        Schema::dropIfExists('riwayat_penggunaan_tindakan_iterasis');
    }
}
