<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatatanBarangKeluarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catatan_barang_keluar', function (Blueprint $table) {
            $table->id();
            $table->integer('barang_id');
            $table->integer('qty');
            $table->integer('perusahaan_penjamin_id');
            $table->integer('relation_id');
            $table->integer('harga_modal');
            $table->integer('harga_jual');
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
        Schema::dropIfExists('catatan_barang_keluars');
    }
}
