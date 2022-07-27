<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name'      => 'administrator',
                'email'     => 'admin@gmail.com',
                'password'  => Hash::make('password'),
                'role'      => 'administrator'
            ],
            [
                'name'      => 'Akutansi',
                'email'     => 'akutansi@gmail.com',
                'password'  => Hash::make('password'),
                'role'      => 'keuangan'
            ],
            [
                'name'      => 'Hrd',
                'email'     => 'hrd@gmail.com',
                'password'  => Hash::make('password'),
                'role'      => 'hrd'
            ],
            [
                'name'      => 'Bagian Gudang',
                'email'     => 'gudang@gmail.com',
                'password'  => Hash::make('password'),
                'role'      => 'bagian_gudang'
            ],
            [
                'name'      => 'Admin Medis',
                'email'     => 'adminmedis@gmail.com',
                'password'  => Hash::make('password'),
                'role'      => 'admin_medis'
            ],
            [
                'name'      => 'Pimpinan',
                'email'     => 'pimpinan@gmail.com',
                'password'  => Hash::make('password'),
                'role'      => 'pimpinan'
            ],
            [
                'name'      => 'Bagian Pendaftaran',
                'email'     => 'pendaftaran@gmail.com',
                'password'  => Hash::make('password'),
                'role'      => 'bagian_pendaftaran'
            ],
            [
                'name'      => 'Poliklinik',
                'email'     => 'poliklinik@gmail.com',
                'password'  => Hash::make('password'),
                'role'      => 'poliklinik'
            ],
            [
                'name'      => 'Kasir',
                'email'     => 'kasir@gmail.com',
                'password'  => Hash::make('password'),
                'role'      => 'kasir'
            ],
            [
                'name'      => 'Laboratorium',
                'email'     => 'laboratorium@gmail.com',
                'password'  => Hash::make('password'),
                'role'      => 'laboratorium'
            ]
        ];

        User::insert($users);
    }
}
