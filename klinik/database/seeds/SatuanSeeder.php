<?php

use Illuminate\Database\Seeder;
use App\Models\Satuan;

class SatuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $satuan = [
            ['satuan'=>'Mg'],
            ['satuan'=>'Box'],
            ['satuan'=>'Kapsul']
        ];
        Satuan::insert($satuan);
    }
}
