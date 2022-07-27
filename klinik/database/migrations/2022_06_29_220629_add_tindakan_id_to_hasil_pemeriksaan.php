<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTindakanIdToHasilPemeriksaan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pendaftaran_hasil_pemeriksaan_lab', function (Blueprint $table) {
            $table->integer('tindakan_id');
            $table->integer('pendaftaran_tindakan_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pendaftaran_hasil_pemeriksaan_lab', function (Blueprint $table) {
            //
        });
    }
}
