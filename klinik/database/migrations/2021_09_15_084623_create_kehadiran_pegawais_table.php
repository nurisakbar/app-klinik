<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKehadiranPegawaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kehadiran_pegawai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id');
            $table->date('tanggal');
            $table->string('jam_masuk');
            $table->string('jam_keluar');
            $table->string('scan_masuk')->nullable();
            $table->string('scan_pulang')->nullable();
            $table->integer('status')->nullable();
            $table->foreignId('shift_id');
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
        Schema::dropIfExists('kehadiran_pegawai');
    }
}
