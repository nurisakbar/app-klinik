<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndikatorPemeriksaanLaboratorium extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('indikator_pemeriksaan_laboratorium', function (Blueprint $table) {
            $table->id();
            $table->string('nama_indikator');
            $table->string('satuan');
            $table->string('nilai_rujukan');
            $table->integer('tindakan_id');
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
        Schema::dropIfExists('indikator_pemeriksaan_laboratorium');
    }
}
