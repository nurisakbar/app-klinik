<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumnBiayaToTarifTableTindakan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tindakan', function (Blueprint $table) {
            $table->renameColumn('biaya_umum', 'tarif_umum');
            $table->renameColumn('biaya_pbjs', 'tarif_bpjs');
            $table->renameColumn('biaya_perusahaan', 'tarif_perusahaan');
            $table->text('pembagian_tarif');
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
