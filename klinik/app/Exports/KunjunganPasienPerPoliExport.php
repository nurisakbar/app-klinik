<?php

namespace App\Exports;

use App\Models\Poliklinik;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;

class KunjunganPasienPerPoliExport implements FromView, ShouldAutoSize, WithEvents, WithTitle
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
        $data['laporan']    = $this->data();
        return view('laporan.kunjungan-perpoli-excel', $data);
    }

    public function title(): string
    {
        return 'Laporan Kunjungan Perpoli';
    }

    public function registerEvents(): array
    {
        $jmlData = count($this->data()) + 1;
        return [
            AfterSheet::class    => function (AfterSheet $event) use ($jmlData) {
                $cellRange = 'A1:G1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(10)->setBold(true);

                $event->sheet->getStyle('A1:C' . $jmlData)->applyFromArray([
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
            $filterPerusahaanAsuransi = "and na.perusahaan_asuransi_id='" . $this->perusahaan_asuransi_id . "'";
        } else {
            $filterPerusahaanAsuransi = "";
        }

        return \DB::select("select po.nomor_poli,po.nama,count(na.id) as jumlah_kunjungan
                            from poliklinik as po 
                            left join nomor_antrian as na on po.id=na.poliklinik_id $filterPerusahaanAsuransi 
                            and left(na.created_at,10) BETWEEN '" . $this->tanggal_awal . "' and '" . $this->tanggal_akhir . "'
                            group by po.id");
    }
}
