<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTindakan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tindakan', function (Blueprint $table) {
            $table->integer('poliklinik_id');
            $table->integer('biaya_umum');
            $table->integer('biaya_perusahaan');
            $table->integer('biaya_pbjs');
            $table->dropColumn('harga');
            $table->boolean('iterasi');
            $table->boolean('penunjang');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tindakan', function (Blueprint $table) {
            //
        });
    }
}
