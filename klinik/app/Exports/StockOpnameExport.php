<?php

namespace App\Exports;

use App\Models\StockOpname;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class StockOpnameExport implements FromView, ShouldAutoSize, WithEvents
{
    public $tanggal_mulai;
    public $tanggal_selesai;

    public function __construct($tanggal_mulai, $tanggal_selesai)
    {
        $this->tanggal_mulai = $tanggal_mulai;
        $this->tanggal_selesai = $tanggal_selesai;
    }

    public function view(): View
    {
        $stock_opnames = StockOpname::with('barang')
            ->whereBetween('tanggal', [$this->tanggal_mulai, $this->tanggal_selesai])
            ->get();
        return view('stock-opname.laporan-stock-opname-excel', ['stock_opnames' => $stock_opnames]);
    }

    public function registerEvents(): array
    {
        $jmlData = StockOpname::count() + 1;
        return [
            AfterSheet::class    => function (AfterSheet $event) use ($jmlData) {
                $cellRange = 'A1:G1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(10)->setBold(true);

                $event->sheet->getStyle('A1:I' . $jmlData)->applyFromArray([
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
