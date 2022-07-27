<?php

namespace App\Http\Controllers;

use App\Exports\LaporanTagihanExport;
use Illuminate\Http\Request;
use DataTables;
use App\Models\PendaftaranTindakan;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\PerusahaanAsuransi;
use App\Models\ViewLaporanPendaftaranTindakan;

class LaporanTagihanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['periode'] = $request->periode ?? date('Y-m');
        $laporanTagihan = ViewLaporanPendaftaranTindakan::query();

        if ($request->periode) {
            $laporanTagihan->whereRaw("left(tanggal,7)='" . $request->periode . "'");
        }

        if ($request->has('nama_perusahaan')) {
            if ($request->nama_perusahaan != '') {
                $laporanTagihan->where('perusahaan_asuransi_id', $request->nama_perusahaan);
            }
        }

        if ($request->ajax()) {
            return DataTables::of($laporanTagihan)
                ->addColumn('tanggal', function ($row) {
                    return tgl_indo($row->tanggal);
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        if ($request->has('action')) {
            if ($request->action == 'download') {
                \Log::info($request->nama_perusahaan);
                return Excel::download(new LaporanTagihanExport($request->periode, $request->nama_perusahaan ?? null), 'Laporan Tagihan Perusahaan ' . date('F Y', strtotime($request->periode)) . '.xlsx');
            }
        }

        $data['perusahaan'] = PerusahaanAsuransi::pluck('nama_perusahaan', 'id');
        return view('laporan-tagihan.index', $data);
    }
}
