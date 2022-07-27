<?php

namespace App\Exports;

use App\Models\PendaftaranTindakan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class LaporanTagihanExport implements FromView, ShouldAutoSize, WithEvents
{
    public $periode;
    public $perusahaan;

    public function __construct($periode, $perusahaan = null)
    {
        $this->periode = $periode;
        $this->perusahaan = $perusahaan;
    }

    public function view(): View
    {

        $data['laporanTagihan'] = $this->data();
        return view('laporan-tagihan.laporan-tagihan-perusahaan-excel', $data);
    }

    public function data()
    {
        $laporanTagihan = \App\Models\ViewLaporanPendaftaranTindakan::query();

        if ($this->periode) {
            $laporanTagihan->whereRaw("left(tanggal,7)='" . $this->periode . "'");
        }


        if ($this->perusahaan != '') {
            $laporanTagihan->where('perusahaan_asuransi_id', $this->perusahaan);
        }


        return $laporanTagihan->get();
    }

    public function registerEvents(): array
    {
        $jmlData = count($this->data()) + 2;
        return [
            AfterSheet::class    => function (AfterSheet $event) use ($jmlData) {
                $cellRange = 'A1:H1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(10)->setBold(true);

                $event->sheet->getStyle('A1:H' . $jmlData)->applyFromArray([
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
}
