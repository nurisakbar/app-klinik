<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class LaporanBarangKeluarExport implements FromView, ShouldAutoSize, WithEvents
{
    protected $tanggal_awal;
    protected $tanggal_akhir;
    protected $perusahaan_penjamin_id;


    public function __construct($tanggal_awal, $tanggal_akhir, $perusahaan_penjamin_id)
    {
        $this->tanggal_awal = $tanggal_awal;
        $this->tanggal_akhir = $tanggal_akhir;
        $this->perusahaan_penjamin_id = $perusahaan_penjamin_id;
    }


    public function view(): View
    {
        $data['laporan']        = $this->data();
        return view('laporan.laporan_pengeluaran_barang_excel', $data);
    }

    public function registerEvents(): array
    {
        $jmlData = count($this->data()) + 1;
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


    public function data()
    {
        $perusahaan_penjamin  = "and perusahaan_penjamin_id='" . $this->perusahaan_penjamin_id . "'";
        $sql = \DB::select("select 
        b.id,b.kode,b.nama_barang,sum(cbk.qty) as jumlah_terjual,
        sum(cbk.harga_modal*cbk.qty) as total_modal,
        sum(cbk.harga_jual*cbk.qty) as total_jual,
        sum(cbk.harga_jual*cbk.qty)-sum(cbk.harga_modal*cbk.qty) as untung
        from barang as b left join catatan_barang_keluar as cbk on cbk.barang_id=b.id $perusahaan_penjamin 
        where left(cbk.created_at,10) between '" . $this->tanggal_awal . "' and '" . $this->tanggal_akhir . "'
        group by b.id");
        return $sql;
    }
}
