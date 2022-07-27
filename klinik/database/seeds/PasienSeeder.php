<?php

use Illuminate\Database\Seeder;
use App\Models\Pasien;

class PasienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pasien::truncate();
        
        $csvFile = fopen(base_path("database/seeds/csv/tbd_pasien_lama.csv"), "r");
  
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                Pasien::create([
                    'nama' => $data['0'],
                    'tempat_lahir' => $data['1'],
                    'tanggal_lahir' => $data['2'],
                    'nomor_asuransi' => $data['3'],
                    'status_pernikahan' => $data['4'],
                    'agama' => $data['5'],
                    'jenis_kelamin' => $data['6'],
                    'alamat' => $data['7'],
                    'nomor_hp' => $data['8'],
                    'rt_rw' => $data['9'],
                    'village_id' => $data['10'],
                    'province_id' => $data['11'],
                    'district_id' => $data['12'],
                    'regency_id' => $data['13'],
                    'suku_bangsa' => $data['14'],
                    'golongan_darah' => $data['15'],
                    'kewarganegaraan' => $data['16'],
                    'pekerjaan' => $data['17'],
                    'pendidikan' => $data['18'],
                    'nama_ibu' => $data['19'],
                    'penanggung_jawab' => $data['20'],
                    'hubungan_pasien' => $data['21'],
                    'alamat_penanggung_jawab' => $data['22'],
                    'nomor_hp_penanggung_jawab' => $data['23'],
                    'nomor_ktp' => $data['24'],
                    'privilage_khusus' => $data['25']
                ]);    
            }
            $firstline = false;
        }
   
        fclose($csvFile);
    }
}
