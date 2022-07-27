<?php

namespace App\Exports;

use App\Models\Pendaftaran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use DB;

class LaporanKunjunganPasien implements FromView, ShouldAutoSize, WithEvents, WithTitle
{
    public $tanggal_awal;
    public $tanggal_akhir;
    public $perusahaan_asuransi_id;


    public function __construct($tanggal_awal, $tanggal_akhir, $perusahaan_asuransi_id)
    {
        $this->tanggal_awal = $tanggal_awal;
        $this->tanggal_akhir = $tanggal_akhir;
        $this->perusahaan_asuransi_id = $perusahaan_asuransi_id;
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $data['laporan'] = $this->data();
        return view('laporan.kunjungan-pasien-excel', $data);
    }

    public function title(): string
    {
        return 'Laporan Kunjungan Pasien';
    }

    public function registerEvents(): array
    {
        $jmlData = count($this->data()) + 1;
        return [
            AfterSheet::class    => function (AfterSheet $event) use ($jmlData) {
                $cellRange = 'A1:G1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(10)->setBold(true);

                $event->sheet->getStyle('A1:E' . $jmlData)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
            },
        ];
    }

    public function data()
    {

        if ($this->perusahaan_asuransi_id != '') {
            $filterPerusahaanAsuransi = " and pas.id='" . $this->perusahaan_asuransi_id . "'";
        } else {
            $filterPerusahaanAsuransi = "";
        }

        return \DB::select("select p.created_at,ps.nomor_rekam_medis,ps.nama,pk.nama as nama_poliklinik,pas.nama_perusahaan as nama_perusahaan_asuransi
        from nomor_antrian as na join pendaftaran as p on p.id=na.pendaftaran_id
        join pasien as ps on ps.id=p.pasien_id
        join poliklinik as pk on pk.id=na.poliklinik_id
        join perusahaan_asuransi as pas on pas.id=na.perusahaan_asuransi_id
        where left(p.created_at,10) between '" . $this->tanggal_awal . "' and '" . $this->tanggal_akhir . "' $filterPerusahaanAsuransi
        GROUP by na.id");
    }
}
