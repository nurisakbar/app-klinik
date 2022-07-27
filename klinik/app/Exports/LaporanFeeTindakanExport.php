<?php

namespace App\Exports;

use App\Models\PendaftaranFeeTindakan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class LaporanFeeTindakanExport implements FromView, ShouldAutoSize, WithEvents
{
    protected $tanggal_mulai;
    protected $tanggal_selesai;
    protected $poliklinik_id;
    protected $user_id;

    public function __construct($tanggal_mulai, $tanggal_selesai, $user_id, $poliklinik_id)
    {
        $this->tanggal_mulai    = $tanggal_mulai;
        $this->tanggal_selesai  = $tanggal_selesai;
        $this->poliklinik_id    = $poliklinik_id;
        $this->user_id          = $user_id;
    }


    public function view(): View
    {
        $fee = $this->data();
        return view('laporan-fee-tindakan.laporan-fee-tindakan-excel', ['fees' => $fee->get()]);
    }

    public function registerEvents(): array
    {
        $jmlData = $this->data()->count() + 2;
        return [
            AfterSheet::class    => function (AfterSheet $event) use ($jmlData) {
                $cellRange = 'A1:L1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(10)->setBold(true);

                $event->sheet->getStyle('A1:L' . $jmlData)->applyFromArray([
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
        $fee = PendaftaranFeeTindakan::select(
            'pendaftaran.created_at as tanggal',
            'users.name as nama_pelaksana',
            'pendaftaran_fee_tindakan.pelaksana',
            'pendaftaran_fee_tindakan.jumlah_fee',
            'tindakan.tarif_umum',
            'tindakan.tarif_perusahaan',
            'tindakan.tarif_bpjs',
            'pendaftaran.kode as nomor_pendaftaran',
            'poliklinik.nama as unit',
            'perusahaan_asuransi.nama_perusahaan as jenis_pelayanan',
            'tindakan.tindakan as nama_tindakan',
            'pasien.nama',
            'pasien.nomor_rekam_medis'
        )

        ->join('nomor_antrian', 'nomor_antrian.pendaftaran_id', 'pendaftaran_fee_tindakan.pendaftaran_id')
        ->join('pendaftaran', 'pendaftaran.id', 'pendaftaran_fee_tindakan.pendaftaran_id')
        ->join('poliklinik', 'poliklinik.id', 'nomor_antrian.poliklinik_id')
        ->join('perusahaan_asuransi', 'perusahaan_asuransi.id', 'nomor_antrian.perusahaan_asuransi_id')
        ->join('tindakan', 'tindakan.id', 'pendaftaran_fee_tindakan.tindakan_id')
        ->join('users', 'users.id', 'pendaftaran_fee_tindakan.user_id')
        ->join('pasien', 'pasien.id', 'pendaftaran.pasien_id')
        ->whereBetween(\DB::raw('left(nomor_antrian.created_at,10)'), [$this->tanggal_mulai,$this->tanggal_selesai]);

        if ($this->poliklinik_id != '') {
            $fee = $fee->where('nomor_antrian.poliklinik_id', $this->poliklinik_id);
        }

        if ($this->user_id != '') {
            $fee = $fee->where('users.id', $this->user_id);
        }

        return $fee;
    }
}
