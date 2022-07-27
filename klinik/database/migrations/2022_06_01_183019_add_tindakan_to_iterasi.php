<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTindakanToIterasi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('paket_iterasi', function (Blueprint $table) {
            $table->integer('biaya')->default(0);
            $table->dropColumn('pendaftaran_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('paket_iterasi', function (Blueprint $table) {
            //
        });
    }
}
