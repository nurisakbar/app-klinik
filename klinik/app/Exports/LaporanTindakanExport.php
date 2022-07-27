<?php

namespace App\Exports;

use App\Models\PendaftaranTindakan;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class LaporanTindakanExport implements FromView, ShouldAutoSize, WithEvents
{
    public $periode;

    public function __construct($periode)
    {
        $this->periode = $periode;
    }

    public function view(): View
    {
        $tanggal_awal = $this->periode . '-01';
        $tanggal_akhir = $this->periode . '-31';

        $pendaftaranTindakan = DB::select(
            "SELECT users.name as dokter,pendaftaran_tindakan.created_at,poliklinik.nama as poliklinik,pasien.nomor_rekam_medis,pendaftaran_tindakan.id,pasien.nama,perusahaan_asuransi.nama_perusahaan,tindakan.tindakan, SUM(tindakan.tarif_umum) as tarif_total
            FROM pendaftaran_tindakan
            JOIN pendaftaran on pendaftaran.id = pendaftaran_tindakan.pendaftaran_id
            JOIN pasien on pasien.id = pendaftaran.pasien_id
            JOIN perusahaan_asuransi on perusahaan_asuransi.id = pendaftaran.jenis_layanan
            JOIN tindakan on tindakan.id = pendaftaran_tindakan.tindakan_id
            JOIN users on users.id = pendaftaran.dokter_id
            JOIN poliklinik on poliklinik.id = pendaftaran.poliklinik_id
            WHERE pendaftaran_tindakan.created_at BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
            GROUP BY pendaftaran.id"
        );

        $data['laporanTindakan'] = $pendaftaranTindakan;

        return view('laporan-tindakan.laporan-tindakan-excel', $data);
    }

    public function registerEvents(): array
    {
        $jmlData = PendaftaranTindakan::count() + 1;
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
