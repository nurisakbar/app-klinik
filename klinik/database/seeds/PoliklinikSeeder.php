<?php

use Illuminate\Database\Seeder;
use App\Models\Poliklinik;

class PoliklinikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $poli = [
            ['nomor_poli'=>'PLK001','nama'=>'Poli Gigi','keterangan'=>'sample text','aktif'=>1],
            ['nomor_poli'=>'PLK002','nama'=>'Poli Umum','keterangan'=>'sample text','aktif'=>1],
            ['nomor_poli'=>'PLK002','nama'=>'Poli Jantung','keterangan'=>'sample text','aktif'=>1]
        ];

        Poliklinik::insert($poli);
    }
}
