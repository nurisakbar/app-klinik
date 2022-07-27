<?php

namespace App\Exports;

use App\Models\Barang;
use App\Models\DistribusiStock;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class StockBarangExport implements FromView, ShouldAutoSize, WithEvents
{
    public $unit_stock_id;

    public function __construct($unit_stock_id)
    {
        $this->unit_stock_id = $unit_stock_id;
    }

    public function view(): View
    {
        $data['barang'] = $this->data();
        return view('unit-stock.stock-excel', $data);
    }


    public function data()
    {
        return Barang::select('barang.nama_barang', 'unit_stock.nama_unit', 'distribusi_stock.jumlah_stock')
        ->leftJoin('distribusi_stock', 'distribusi_stock.barang_id', 'barang.id')
        ->leftJoin('unit_stock', 'unit_stock.id', 'distribusi_stock.unit_stock_id')
        ->where('distribusi_stock.unit_stock_id', $this->unit_stock_id)
        ->orderBy('barang.nama_barang', 'ASC')
        ->get();
    }

    public function registerEvents(): array
    {
        $jmlData = count($this->data()) + 1;
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
}
