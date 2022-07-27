<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notifikasi', function (Blueprint $table) {
            $table->integer('user_id')->nullable();
            $table->integer('pasien_id')->nullable();
            $table->integer('poliklinik_id')->nullable()->change();
            $table->boolean('display')->default(0);
            $table->text('link')->nullable();
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
