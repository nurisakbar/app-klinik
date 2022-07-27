<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendaftaranObatRaciksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pendaftaran_obat_racik', function (Blueprint $table) {
            $table->id();
            $table->integer('pendaftaran_id');
            $table->string('aturan_pakai');
            $table->integer('jumlah_kemasan');
            $table->string('kemasan');
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
        Schema::dropIfExists('pendaftaran_obat_raciks');
    }
}
