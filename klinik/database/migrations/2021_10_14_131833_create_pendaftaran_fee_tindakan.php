<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendaftaranFeeTindakan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pendaftaran_fee_tindakan', function (Blueprint $table) {
            $table->id();
            $table->integer('tindakan_id');
            $table->integer('pendaftaran_id');
            $table->integer('jumlah_fee');
            $table->integer('user_id');
            $table->string('pelaksana');
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
        Schema::dropIfExists('pendaftaran_fee_tindakan');
    }
}
