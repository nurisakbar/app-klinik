<?php

namespace App\Exports;

use App\Models\PengeluaranOperasional;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use DB;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;

class LaporanPengeluaranExport implements FromView, ShouldAutoSize, WithEvents, WithTitle
{
    public $tanggal;
    public $nama_shift;
    public $poliklinik_id;

    public function __construct($tanggal, $nama_shift, $poliklinik_id, $metode_pembayaran)
    {
        $this->tanggal          = $tanggal;
        $this->nama_shift       = $nama_shift;
        $this->poliklinik_id    = $poliklinik_id;
    }

    public function title(): string
    {
        return 'Laporan Pengeluaran';
    }

    public function view(): View
    {

        $data['pengeluaran'] = $this->data()->get();
        return view('laporan-transaksi.laporan-pengeluaran-excel', $data);
    }

    public function registerEvents(): array
    {
        $jmlData = $this->data()->count() + 2;
        return [
            AfterSheet::class    => function (AfterSheet $event) use ($jmlData) {
                $cellRange = 'A1:D1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(10)->setBold(true);

                $event->sheet->getStyle('A1:D' . $jmlData)->applyFromArray([
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
        return PengeluaranOperasional::where('tanggal', $this->tanggal);
    }
}
