<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrigerHapusItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement("CREATE TRIGGER after_pendaftaran_obat_racik_detail_delete
        AFTER DELETE
        ON pendaftaran_obat_racik_detail FOR EACH ROW
        delete from catatan_barang_keluar where relation_id=old.id");
        
        \DB::statement("CREATE TRIGGER after_pendaftaran_resep_delete
        AFTER DELETE
        ON pendaftaran_resep FOR EACH ROW
        delete from catatan_barang_keluar where relation_id=old.id");

        \DB::statement("
        CREATE TRIGGER after_pendaftaran_obat_racik_delete
        AFTER DELETE
        ON pendaftaran_obat_racik FOR EACH ROW
        delete from pendaftaran_obat_racik_detail where pendaftaran_obat_racik_id=old.id");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('triger_hapus_item');
    }
}
