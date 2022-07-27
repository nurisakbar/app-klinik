<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermintaanBarangInternalDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permintaan_barang_internal_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('permintaan_barang_internal_id')->nullable();
            $table->integer('barang_id');
            $table->integer('jumlah_diminta');
            $table->integer('jumlah_diterima')->nullable();
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
        Schema::dropIfExists('permintaan_barang_internal_detail');
    }
}
