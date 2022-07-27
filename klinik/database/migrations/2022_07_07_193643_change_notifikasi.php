<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNotifikasi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notifikasi', function (Blueprint $table) {
            $table->string('notifikasi_judul');
            $table->string('notifikasi_pesan');
            $table->dropColumn('pesan_notifikasi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notifikasi', function (Blueprint $table) {
            //
        });
    }
}
