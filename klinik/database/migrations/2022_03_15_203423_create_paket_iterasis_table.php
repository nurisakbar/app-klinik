<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaketIterasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paket_iterasi', function (Blueprint $table) {
            $table->id();
            $table->integer('pasien_id');
            $table->integer('quota');
            $table->integer('tindakan_id');
            $table->integer('pendaftaran_id');
            $table->timestamps();
        });


        Schema::table('tindakan', function (Blueprint $table) {
            $table->integer('quota')->after('iterasi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paket_iterasis');
    }
}
