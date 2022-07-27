<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poliklinik;
use App\Exports\LaporanKunjungan;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use DataTables;
use App\Models\Setting;
use App\Models\Pendaftaran;
use App\Models\PendaftaranObatRacik;
use App\Models\PendaftaranObatRacikDetail;
use App\Models\PendaftaranResep;
use App\Models\PerusahaanAsuransi;
use App\Exports\LaporanBarangKeluarExport;

class LaporanController extends Controller
{
    public function laporanKunjunganPerPoli(Request $request)
    {
        $data['tanggal_awal']           = $request->tanggal_awal ?? date('Y-m-d');
        $data['tanggal_akhir']          = $request->tanggal_akhir ?? date('Y-m-d');
        $data['perusahaan_penjamin_id'] = $request->perusahaan_penjamin_id ?? null;
        if ($data['perusahaan_penjamin_id'] != '') {
            $filterPerusahaanAsuransi = "and na.perusahaan_asuransi_id='" . $data['perusahaan_penjamin_id'] . "'";
        } else {
            $filterPerusahaanAsuransi = "";
        }

        $data['laporan']                = \DB::select("select po.nomor_poli,po.nama,count(na.id) as jumlah_kunjungan
                                            from poliklinik as po 
                                            left join nomor_antrian as na on po.id=na.poliklinik_id $filterPerusahaanAsuransi
                                            and left(na.created_at,10) BETWEEN '" . $data['tanggal_awal'] . "' and '" . $data['tanggal_akhir'] . "'
                                            group by po.id");

        if ($request->has('type')) {
            if ($request->type == 'excel') {
                $nama_file = 'laporan-kunjungan-pasien-perpoli-periode-' . $data['tanggal_awal'] . '-sampai-' . $data['tanggal_akhir'] . '.xlsx';
                return Excel::download(new LaporanKunjungan($data['tanggal_awal'], $data['tanggal_akhir'], $data['perusahaan_penjamin_id']), $nama_file);
            }
        }
        $data['perusahaan_asuransi'] = PerusahaanAsuransi::pluck('nama_perusahaan', 'id');
        return view('laporan.kunjungan-perpoli', $data);
    }

    public function jumlahPasienPerdiagnosa()
    {
        $data['tanggal_awal']           = $request->tanggal_awal ?? date('Y-m-d');
        $data['tanggal_akhir']          = $request->tanggal_akhir ?? date('Y-m-d');
        $data['laporan'] = \DB::select("select i.indonesia,count(pt.id) as jumlah
                from tbm_icd as i join pendaftaran_diagnosa as pt on i.id=pt.tbm_icd_id
                group by i.id order by jumlah desc limit 10");
        return view('laporan.pasien-per-diagnosa', $data);
    }

    public function label($id)
    {

        $data['setting']            = Setting::first();
        $data['pendaftaran']        = Pendaftaran::with('pasien')->findOrFail($id);
        $data['obatRacik']          = PendaftaranObatRacik::where('pendaftaran_id', $id)->get();
        $data['pendaftaranResep']   = PendaftaranResep::where('pendaftaran_id', $id)->where('jenis', 'non racik')->get();

        //return $data['obatRacik'];

        $dataCetak = [];
        $i = 1;
        foreach ($data['obatRacik'] as $row) {
            $dataCetak[] = [
                'barang' => 'Racik - ' . $i . ' Qty( ' . $row->jumlah_kemasan . ')',
                'jumlah' => '',
                'aturan_pakai' => $row->aturan_pakai,
            ];
            $i++;
        }

        foreach ($data['pendaftaranResep'] as $row2) {
            $dataCetak[] = [
                'barang' => $row2->barang->nama_barang,
                'jumlah' => $row2->jumlah,
                'aturan_pakai' => $row2->aturan_pakai,
            ];
        }

        $data['dataCetak'] = $dataCetak;

        //return view('label-cetak',$data);
        $customPaper = array(0,0,113,170);
        $pdf = PDF::loadView('label-cetak', $data)->setPaper($customPaper, 'landscape');
        return $pdf->stream();
    }



    public function laporanBarangKeluar(Request $request)
    {
        $data['tanggal_awal']   = $request->tanggal_awal ?? date('Y-m-d');
        $data['tanggal_akhir']  = $request->tanggal_akhir ?? date('Y-m-d');
        $data['perusahaan_penjamin_id'] = $request->perusahaan_penjamin_id ?? 1;
        if ($request->has('perusahaan_penjamin_id')) {
            $perusahaan_penjamin  = "and perusahaan_penjamin_id='" . $request->perusahaan_penjamin_id . "'";
        } else {
            $perusahaan_penjamin    = "";
        }

        $sql = \DB::select("select 
        b.id,b.kode,b.nama_barang,sum(cbk.qty) as jumlah_terjual,
        sum(cbk.harga_modal*cbk.qty) as total_modal,
        sum(cbk.harga_jual*cbk.qty) as total_jual,
        sum(cbk.harga_jual*cbk.qty)-sum(cbk.harga_modal*cbk.qty) as untung
        from barang as b left join catatan_barang_keluar as cbk on cbk.barang_id=b.id $perusahaan_penjamin 
        where left(cbk.created_at,10) between '" . $data['tanggal_awal'] . "' and '" . $data['tanggal_akhir'] . "'
        group by b.id");

        if ($request->ajax()) {
            return DataTables::of($sql)
                ->addColumn('jumlah_terjual', function ($row) {
                    return $row->jumlah_terjual ?? 0;
                })
                ->addIndexColumn()
                ->make(true);
        }

        if ($request->has('type')) {
            if ($request->type == 'excel') {
                return Excel::download(new LaporanBarangKeluarExport($data['tanggal_awal'], $data['tanggal_akhir'], $data['perusahaan_penjamin_id']), 'Laporan-Barang-Keluar.xlsx');
            }
        }
        $data['perusahaan_asuransi'] = PerusahaanAsuransi::pluck('nama_perusahaan', 'id');
        return view('laporan.laporan_pengeluaran_barang', $data);
    }
}
