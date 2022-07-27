<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendaftaranResep extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pendaftaran_resep', function (Blueprint $table) {
            $table->id();
            $table->integer('pendaftaran_id');
            $table->integer('barang_id');
            $table->integer('jumlah');
            $table->string('satuan');
            $table->text('aturan_pakai');
            $table->enum('jenis', ['racik', 'non racik']);
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
        Schema::dropIfExists('pendaftaran_resep');
    }
}
