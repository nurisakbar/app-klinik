<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnInPendaftaranTindakanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pendaftaran_tindakan', function (Blueprint $table) {
            $table->integer('tbm_icd_id')->nullable();
            $table->string('anamnesa')->nullable();
            $table->string('kode_gigi')->nullable();
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
