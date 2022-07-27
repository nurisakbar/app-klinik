<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPoliklinikId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pendaftaran_tindakan', function (Blueprint $table) {
            $table->integer('poliklinik_id')->nullable();
        });

        Schema::table('pendaftaran_diagnosa', function (Blueprint $table) {
            $table->integer('poliklinik_id')->nullable();
        });

        Schema::table('pendaftaran_obat_racik', function (Blueprint $table) {
            $table->integer('poliklinik_id')->nullable();
        });

        Schema::table('pendaftaran_resep', function (Blueprint $table) {
            $table->integer('poliklinik_id')->nullable();
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pendaftaran_tindakan', function (Blueprint $table) {
            //
        });
    }
}
