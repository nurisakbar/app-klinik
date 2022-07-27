<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDokterIdNomorAntrian extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nomor_antrian', function (Blueprint $table) {
            $table->integer('dokter_id');
            $table->boolean('sudah_dipanggil');
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
