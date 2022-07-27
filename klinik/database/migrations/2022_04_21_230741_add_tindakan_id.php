<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTindakanId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nomor_antrian', function (Blueprint $table) {
            $table->integer('tindakan_id')->nullable();
            $table->string('status_pemeriksaan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nomor_antrian', function (Blueprint $table) {
            //
        });
    }
}
