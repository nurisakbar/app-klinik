<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUnitStockId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('poliklinik', function (Blueprint $table) {
            $table->integer('unit_stock_id')->nullable();
        });

        Schema::table('distribusi_stock', function (Blueprint $table) {
            $table->integer('poliklinik_id')->nullable();
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('poliklinik', function (Blueprint $table) {
            //
        });
    }
}
