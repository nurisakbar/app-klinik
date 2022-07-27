<?php

use Illuminate\Database\Seeder;
use App\Models\PerusahaanAsuransi;
class PerusahaanAsuransiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $perusahaan = [
            ['nama_perusahaan' =>'Umum'],
            ['nama_perusahaan'=>'BPJS']
        ];
        PerusahaanAsuransi::insert($perusahaan);
    }
}
