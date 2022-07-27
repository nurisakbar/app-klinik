<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use App\Models\Satuan;
use App\Models\Kategori;
use App\Models\Barang;

class ImportBarangExcel implements ShouldQueue
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


        //Barang::truncate();
        $reader = ReaderEntityFactory::createXLSXReader();
        $filepath = public_path($this->filePath);
        $reader->open($filepath);

        foreach ($reader->getSheetIterator() as $sheet) {
            $nomor = 1;
            $data = [];
            foreach ($sheet->getRowIterator() as $row) {
                if ($nomor > 1) {
                    $cells                      = $row->getCells();
                    $jenis_barang               = $cells[1]->getValue();
                    $kode_barang                = $cells[2]->getValue();
                    $nama_barang                = $cells[3]->getValue();
                    $jumlah_satuan_terbesar     = $cells[4]->getValue();
                    $satuan_terbesar            = Satuan::firstOrCreate(['satuan' => $cells[5]->getValue()], ['satuan' => $cells[6]->getValue()]);
                    $jumlah_satuan_terkecil     = $cells[6]->getValue();
                    $satuan_terkecil            = Satuan::firstOrCreate(['satuan' => $cells[7]->getValue()], ['satuan' => $cells[7]->getValue()]);
                    $jenis                      = strtolower($cells[8]->getValue());
                    $harga                      = (int) $cells[9]->getValue();
                    $margin                     = (int) $cells[10]->getValue();
                    $pbf                        = \App\Models\PedagangBesarFarmasi::firstOrCreate(['nama_pbf' => $cells[12]->getValue()], ['nama_pbf' => $cells[12]->getValue()]);
                    $kategori                   = Kategori::firstOrCreate(['nama_kategori' => $cells[8]->getValue()], ['nama_kategori' => $cells[8]->getValue()]);

                    $asuransi = strpos($cells[11]->getValue(), 'BPJS') !== false ? 'bpjs' : 'umum';

                    $data = [
                        'kode'                      =>  $kode_barang,
                        'nama_barang'               =>  $nama_barang,
                        'keterangan'                =>  null,
                        'jenis_barang_kedua'        =>  $cells[9]->getValue(),
                        'harga'                     =>  $harga,
                        'kategori_id'               =>  $kategori->id,
                        'satuan_terbesar_id'        =>  $satuan_terbesar->id,
                        'jumlah_satuan_terbesar'    =>  $jumlah_satuan_terbesar,
                        'pelayanan'                 =>  $asuransi,
                        'satuan_terkecil_id'        =>  $satuan_terkecil->id,
                        'jumlah_satuan_terkecil'    =>  $jumlah_satuan_terkecil,
                        'margin'                    =>  $margin,
                        'jenis_barang'              =>  $jenis,
                        'pbf_id'                    =>  $pbf->id,
                        'aktif'                     =>  1
                    ];
                    $matchThese = ['nama_barang' => $nama_barang];
                    Barang::updateOrCreate($matchThese, $data);
                }
                $nomor++;
            }
        }
    }
}
