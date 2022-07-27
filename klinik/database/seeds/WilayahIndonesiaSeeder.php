<?php

use Illuminate\Database\Seeder;

class WilayahIndonesiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql = "database/seeds/sql/wilayah_administratif_indonesia.sql";
        $db = [
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'host' => env('DB_HOST'),
            'port' => env('DB_PORT'),
            'database' => env('DB_DATABASE')
        ];
        
        exec("mysql --user={$db['username']} --password={$db['password']} --port={$db['port']} --host={$db['host']} --database {$db['database']} < $sql");

        DB::statement("DROP VIEW IF EXISTS view_wilayah_administratif_indonesia");
        DB::statement("create view view_wilayah_administratif_indonesia as SELECT 
        villages.id as village_id,
        villages.name as village_name,
        districts.id as district_id,
        districts.name as district_name,
        regencies.id as regency_id,
        regencies.name as regency_name,
        provinces.id as province_id,
        provinces.name as province_name
        FROM villages
        left JOIN districts on districts.id=villages.district_id
        left join regencies on regencies.id=districts.regency_id
        left join provinces on provinces.id=regencies.province_id");
    }
}
