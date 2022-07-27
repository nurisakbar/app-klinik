<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddToleransiTerlambat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shift', function (Blueprint $table) {
            $table->string('toleransi_terlambat_masuk');
            $table->string('toleransi_terlambat_pulang');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shift', function (Blueprint $table) {
            //
        });
    }
}
