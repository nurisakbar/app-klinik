<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRujukanInternal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rujukan_internal', function (Blueprint $table) {
            $table->id();
            $table->integer('users_id');
            $table->integer('poliklinik_id');
            $table->integer('pasien_id');
            $table->integer('tindakan_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rujukan_internal');
    }
}
