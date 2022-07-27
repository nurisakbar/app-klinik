<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKomponenGajisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('komponen_gaji', function (Blueprint $table) {
            $table->id();
            $table->string('nama_komponen');
            $table->string('keterangan')->nullable();
            $table->integer('jumlah');
            $table->enum('jenis', ['penambah','pengurang']);
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
        Schema::dropIfExists('komponen_gaji');
    }
}
