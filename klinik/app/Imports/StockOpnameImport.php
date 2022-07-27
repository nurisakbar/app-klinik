<?php

namespace App\Imports;

use Exception;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;

class StockOpnameImport implements ToModel
{
    protected $tanggal;

    public function __construct($tanggal)
    {
        $this->tanggal = $tanggal;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if ($row[1] != "Kode Barang") {
            $barang = DB::table('barang')->where('kode', $row[1])->first();

            if ($barang) {
                DB::table('stock_opname')->insert([
                    'kode_barang' => $row[1],
                    'stock_real' => $row[3],
                    'stock_sebelumnya' => $barang->stock,
                    'tanggal' => $this->tanggal
                ]);

                DB::table('barang')->where('kode', $row[1])
                    ->update(['stock' => $row[3]]);
            } else {
                throw new Exception("File tidak valid");
            }
        }
    }
}
