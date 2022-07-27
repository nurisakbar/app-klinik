<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEnumJenisPendaftaranResep extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pendaftaran_resep', function (Blueprint $table) {
            $table->integer('tindakan_id')->nullable();
        });

        \DB::statement("ALTER TABLE pendaftaran_resep MODIFY COLUMN jenis ENUM('racik', 'non racik', 'bhp')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pendaftaran_resep', function (Blueprint $table) {
            //
        });
    }
}
