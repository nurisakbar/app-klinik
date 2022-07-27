<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPoliklinikIdToPendaftarabFee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pendaftaran_fee_tindakan', function (Blueprint $table) {
            $table->integer('poliklinik_id')->after('pendaftaran_id')->nullable();
        });

        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->dropColumn('poliklinik_id');
            $table->dropColumn('dokter_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('abc', function (Blueprint $table) {
            //
        });
    }
}
