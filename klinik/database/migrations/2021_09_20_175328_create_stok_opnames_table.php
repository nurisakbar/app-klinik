<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStokOpnamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_opname', function (Blueprint $table) {
            $table->id();
            $table->string('barang_id');
            $table->integer('jumlah_real');
            $table->integer('stock_sebelumnya');
            $table->date('tanggal'); // tanggal melakukan stock opname
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
        Schema::dropIfExists('stock_opname');
    }
}
