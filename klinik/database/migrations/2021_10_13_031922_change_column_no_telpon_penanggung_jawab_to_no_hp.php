<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnNoTelponPenanggungJawabToNoHp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pasien', function (Blueprint $table) {
            $table->renameColumn('no_telp_penanggung_jawab', 'nomor_hp_penanggung_jawab');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
            //
        });
    }
}
