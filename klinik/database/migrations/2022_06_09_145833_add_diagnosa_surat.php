<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDiagnosaSurat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('surat_sehat_sakit', function (Blueprint $table) {
            $table->text('diagnosa')->nullable();
            $table->dropColumn('pilihan_cetak');
            $table->dropColumn('selama');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('surat_sehat_sakit', function (Blueprint $table) {
            //
        });
    }
}
