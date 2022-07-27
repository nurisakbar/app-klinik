<?php

namespace App\Exports;

use App\Models\Barang;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class BarangExport implements FromView, ShouldAutoSize, WithEvents
{
    public function view(): View
    {
        $barang = Barang::with(['satuanTerbesar', 'satuanTerkecil'])->get();
        return view('barang.laporan-barang-excel', ['barangs' => $barang]);
    }

    public function registerEvents(): array
    {
        $jmlData = Barang::count() + 1;
        return [
            AfterSheet::class    => function (AfterSheet $event) use ($jmlData) {
                $cellRange = 'A1:G1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(10)->setBold(true);

                $event->sheet->getStyle('A1:G' . $jmlData)->applyFromArray([
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
