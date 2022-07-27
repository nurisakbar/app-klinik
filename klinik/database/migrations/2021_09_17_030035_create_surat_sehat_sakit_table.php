<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuratSehatSakitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_sehat_sakit', function (Blueprint $table) {
            // Surat Sakit
            $table->id();
            $table->foreignId('pasien_id');
            $table->foreignId('user_id');
            $table->string('selama')->nullable();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable();

            // Surat Sehat
            $table->string('keperluan')->nullable();
            $table->string('tekanan_darah')->nullable();
            $table->string('tinggi_badan')->nullable();
            $table->string('berat_badan')->nullable();
            $table->string('golongan_darah')->nullable();
            $table->enum('tipe_surat', ['surat sehat', 'surat sakit']);
            $table->string('pilihan_cetak');
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
        Schema::dropIfExists('surat_sehat_sakits');
    }
}
