<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use App\Models\PerusahaanAsuransi;
use App\Models\Pasien;
use App\Models\WilayahAdministratifIndonesia;

class ImportPasienExcel implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $filePath;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {


        $reader = ReaderEntityFactory::createXLSXReader();
        $filepath = public_path('uploads/' . $this->filePath);
        $reader->open($filepath);
        Pasien::truncate();
        foreach ($reader->getSheetIterator() as $sheet) {
            $nomor = 1;
            $data = [];
            foreach ($sheet->getRowIterator() as $row) {
                if ($nomor > 1) {
                    $cells                      = $row->getCells();
                    $nomor_rekamedis            = $cells[0]->getValue();
                    $nama_pasien                = $cells[1]->getValue();
                    $tempat_lahir               = $cells[2]->getValue();
                    $tanggal_lahir              = $cells[3]->getValue();
                    $perusahaan_penjamin        = PerusahaanAsuransi::firstOrCreate(['nama_perusahaan' => $cells[4]->getValue()], ['nama_perusahaan' => $cells[4]->getValue()]);
                    $jenis_kelamin              = $cells[5]->getValue() == 'PRIA' ? 'pria' : 'wanita';
                    $alamat                     = $cells[6]->getValue();
                    $alamat_tdk_lengkap         = $cells[7]->getValue();
                    $nomor_hp                   = $cells[8]->getValue();
                    $kabupaten                  = $cells[9]->getValue();
                    $kecataman                  = $cells[10]->getValue();
                    $kelurahan                  = $cells[11]->getValue();
                    $nama_ibu                   = $cells[12]->getValue();
                    $nama_penjamin              = $cells[13]->getValue();
                    $hubungan                   = strtolower($cells[14]->getValue());
                    $alamat_penjamin            = $cells[15]->getValue();
                    $telpon_penjamin            = $cells[16]->getValue();

                    $wilayah = WilayahAdministratifIndonesia::where('regency_name', $kabupaten)
                                ->where('district_name', $kecataman)
                                ->where('village_name', $kelurahan)->first();

                    $data[] = [
                        'nomor_ktp'                 => '',
                        'nama'                      =>  $nama_pasien,
                        'nomor_hp'                  =>  $nomor_hp,
                        'pekerjaan'                 =>  null,
                        'alamat'                    =>  $alamat_tdk_lengkap,
                        'tempat_lahir'              =>  $tempat_lahir,
                        'tanggal_lahir'             =>  $tanggal_lahir,
                        'jenis_kelamin'             =>  $jenis_kelamin,
                        'pendidikan'                =>  null,
                        'agama'                     =>  null,
                        'status_pernikahan'         =>  null,
                        'province_id'               =>  $wilayah->province_id ?? null,
                        'regency_id'                =>  $wilayah->regency_id ?? null,
                        'district_id'               =>  $wilayah->district_id ?? null,
                        'village_id'                =>  $wilayah->village_id ?? null,
                        'nama_ibu'                  =>  $nama_ibu,
                        'nomor_rekam_medis'         =>  $nomor_rekamedis,
                        'kewarganegaraan'           =>  'wni',
                        'penanggung_jawab'          =>  $nama_penjamin,
                        'hubungan_pasien'           =>  $hubungan,
                        'alamat_penanggung_jawab'   =>  $alamat_penjamin,
                        'nomor_hp_penanggung_jawab' =>  $telpon_penjamin
                    ];
                }
                $nomor++;
            }
        }

        $insert_data = collect($data); // Make a collection to use the chunk method
        // it will chunk the dataset in smaller collections containing 500 values each.
        // Play with the value to get best result
        $chunks = $insert_data->chunk(500);

        foreach ($chunks as $chunk) {
            \DB::table('pasien')->insert($chunk->toArray());
        }




        //Pasien::insert($data);
    }
}
