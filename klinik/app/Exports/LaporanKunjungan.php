<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\LaporanKunjunganPasien;
use App\Exports\KunjunganPasienPerPoliExport;

class LaporanKunjungan implements WithMultipleSheets
{
    public $periode_awal;
    public $periode_akhir;
    public $perusahaan_asuransi_id;

    public function __construct($periode_awal, $periode_akhir, $perusahaan_asuransi_id)
    {
        $this->periode_awal = $periode_awal;
        $this->periode_akhir = $periode_akhir;
        $this->perusahaan_asuransi_id = $perusahaan_asuransi_id;
    }
    /**
    * @return \Illuminate\Support\Collection
    */


    public function sheets(): array
    {
        return [
            new KunjunganPasienPerPoliExport($this->periode_awal, $this->periode_akhir, $this->perusahaan_asuransi_id),
            new LaporanKunjunganPasien($this->periode_awal, $this->periode_akhir, $this->perusahaan_asuransi_id)
        ];
    }
}
