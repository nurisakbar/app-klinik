<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\DokterPoliklinik;
use App\User;
use App\Models\Poliklinik;

class DokterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password = Hash::make('password');
        $dokter = [
            [
                'kode'      =>  'DR001',
                'name'      =>  'Asep Nugraha',
                'email'     =>  'asep@gmail.com',
                'role'      =>  'dokter',
                'password'  =>  $password,
                'spesialis' =>  'umum',
                'nomor_hp'  =>  '089699935552'
            ],
            [
                'kode'      =>  'DR001',
                'name'      =>  'Muhammad Muzaki',
                'email'     =>  'zaki@gmail.com',
                'role'      =>  'dokter',
                'password'  =>  $password,
                'spesialis' =>  'umum',
                'nomor_hp'  =>  '089699935554'
            ],
            [
                'kode'      =>  'DR001',
                'name'      =>  'Hafizah',
                'email'     =>  'hafizah@gmail.com',
                'role'      =>  'dokter',
                'password'  =>  $password,
                'spesialis' =>  'umum',
                'nomor_hp'  =>  '089699935553'
                ]
        ];

        User::insert($dokter);

        $dokter = User::where('role', 'dokter')->pluck('id');
        $dokterIndex=0;
        foreach (Poliklinik::all() as $poliklinik) {
            DokterPoliklinik::create(['user_id'=>$dokter[$dokterIndex],'poliklinik_id'=>$poliklinik->id]);
            $dokterIndex++;
        }
    }
}
