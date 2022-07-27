<?php

namespace App\Http\Controllers;

use App\Exports\LaporanTransaksiAllExport;
use App\Models\Pendaftaran;
use App\Models\PendaftaranResep;
use App\Models\PendaftaranTindakan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Poliklinik;
use App\Models\ViewPendaftaran;

class LaporanTransaksiController extends Controller
{
    public function index(Request $request)
    {
        $data['tanggal_awal']   = $request->tanggal_awal ?? date('Y-m-d');
        $data['tanggal_akhir']  = $request->tanggal_akhir ?? date('Y-m-d');

        $awal = date('Y-m-d', strtotime($data['tanggal_awal']));
        $akhir = date('Y-m-d', strtotime($data['tanggal_akhir']));

        $nomorAntrian = ViewPendaftaran::whereBetween('tanggal', [$awal, $akhir])->where('status_pembayaran', 1);

        if ($request->ajax()) {
            return DataTables::of($nomorAntrian)
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-danger btn-sm" href="/pembayaran/' . $row->id . '/kwitansi"><i class="fa fa-print"></i> Kwitansi</a></div>';
                    return $btn;
                })
                ->addColumn('total_transaksi', function ($row) {
                    return $row->total_bayar + $row->biaya_tambahan;
                })
                ->addColumn('tanggal', function ($row) {
                    return substr($row->created_at, 0, 16);
                })
                ->rawColumns(['action', 'code'])
                ->addIndexColumn()
                ->make(true);
        }

        $data['shift'] = config('datareferensi.kasir_shift');
        $data['metodePembayaran']   = ['cash' => 'Cash', 'transfer' => 'Transfer', 'debit' => 'Debit','bpjs' => 'BPJS'];
        $data['poliklinik'] = Poliklinik::pluck('nama', 'id');
        return view('laporan-transaksi.index', $data);
    }

    public function export(Request $request)
    {
        return Excel::download(new LaporanTransaksiAllExport($request->tanggal, $request->nama_shift, $request->poliklinik_id, $request->metode_pembayaran), 'Laporan Transaksi ' . date('Y-m-d') . '.xlsx');
    }
}
