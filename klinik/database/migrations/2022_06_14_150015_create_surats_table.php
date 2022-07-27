<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuratsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat', function (Blueprint $table) {
            $table->id();
            $table->integer('pendaftaran_id');
            $table->string('jenis_surat');
            $table->string('keperluan')->nullable();
            $table->string('hasil_pemeriksaan_mata')->nullable();
            $table->string('saran')->nullable();
            $table->string('kesan')->nullable();
            $table->integer('dokter_id')->nullable();
            $table->text('tindakan_yang_telah_dilakukan')->nullable();
            $table->text('lain_lain')->nullable();
            $table->text('terapi_yang_telah_diberikan');
            $table->text('diagnosa_sementara')->nullable();
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
        Schema::dropIfExists('surats');
    }
}
