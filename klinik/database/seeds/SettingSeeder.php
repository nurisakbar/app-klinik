<?php

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting = [
            'nama_instansi'     =>  'Klinik Nur Wahid',
            'nomor_telpon'      =>  '021-11111',
            'email'             =>  'klinik@gmail.com',
            'alamat'            =>  'jalan ABC nomor'
        ];

        Setting::insert($setting);
    }
}
