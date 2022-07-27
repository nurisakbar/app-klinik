<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewUnitStockView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement("create view view_distribusi_stock as select b.kode,b.nama_barang,u.nama_unit,d.unit_stock_id,s1.satuan as satuan_terkecil,s2.satuan as satuan_terbesar,k.nama_kategori,d.jumlah_stock
        from distribusi_stock as d join barang as b on b.id=d.barang_id
        join unit_stock as u on d.unit_stock_id=u.id
        join satuan as s1 on s1.id=b.satuan_terkecil_id
        join satuan as s2 on s2.id=b.satuan_terbesar_id
        join kategori as k on k.id=b.kategori_id");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('view_unit_stock_view');
    }
}
