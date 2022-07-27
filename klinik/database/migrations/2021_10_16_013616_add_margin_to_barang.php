<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMarginToBarang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('barang', function (Blueprint $table) {
            $table->integer('margin')->default(0);
            $table->enum('pelayanan', ['pbjs','umum'])->default('umum');
            $table->integer('jumlah_satuan_terbesar')->default(1);
            $table->integer('jumlah_satuan_terkecil')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('barang', function (Blueprint $table) {
            //
        });
    }
}
