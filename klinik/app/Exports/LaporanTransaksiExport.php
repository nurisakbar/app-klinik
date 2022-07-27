<?php

namespace App\Exports;

use App\Models\Pendaftaran;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use DB;
use App\Models\PengeluaranOperasional;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Models\ViewPendaftaran;

class LaporanTransaksiExport implements FromView, ShouldAutoSize, WithEvents, withTitle
{
    public $tanggal;
    public $nama_shift;
    public $poliklinik_id;
    public $metode_pembayaran;

    public function __construct($tanggal, $nama_shift, $poliklinik_id, $metode_pembayaran)
    {
        $this->tanggal          = $tanggal;
        $this->nama_shift       = $nama_shift;
        $this->poliklinik_id    = $poliklinik_id;
        $this->metode_pembayaran    = $metode_pembayaran;
    }

    public function title(): string
    {
        return 'Laporan Transaksi';
    }

    public function view(): View
    {

        $nomorAntrian = $this->data();
        $data['laporan_transaksi'] = $nomorAntrian;
        $data['jumlah_pendaftaran'] = Pendaftaran::count();

        $data['pengeluaran'] = PengeluaranOperasional::all();
        $data['nomorAntrian'] = $nomorAntrian;
        return view('laporan-transaksi.laporan-transaksi-excel', $data);
    }

    public function data()
    {
        $shift = config('datareferensi.kasir_shift');
        $selectedShift = $shift[array_search($this->nama_shift, array_column($shift, 'nama_shift'))];
        $awal   = $this->tanggal . ' ' . $selectedShift['waktu_mulai'];
        $akhir  = $this->tanggal . ' ' . $selectedShift['waktu_selesai'];
        if ($this->nama_shift != '') {
            $nomorAntrian = ViewPendaftaran::whereBetween('created_at', [$awal, $akhir])
                            ->where('status_pembayaran', 1);
        } else {
            $nomorAntrian = ViewPendaftaran::whereBetween('tanggal', [substr($awal, 0, 10), substr($akhir, 0, 10)])
                            ->where('status_pembayaran', 1);
        }


        if ($this->metode_pembayaran != '') {
            $nomorAntrian->where('metode_pembayaran', $this->metode_pembayaran);
        }
        return $nomorAntrian;
    }

    public function registerEvents(): array
    {
        $jmlData = $this->data()->count() + 2;
        return [
            AfterSheet::class    => function (AfterSheet $event) use ($jmlData) {
                $cellRange = 'A1:K1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(10)->setBold(true);

                $event->sheet->getStyle('A1:K' . $jmlData)->applyFromArray([
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
