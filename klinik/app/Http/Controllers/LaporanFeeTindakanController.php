<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\PendaftaranFeeTindakan;
use App\Models\Pegawai;
use App\Models\ViewPendaftaranFeeTindakan;
use App\Exports\LaporanFeeTindakanExport;
use Excel;
use DB;
use App\Models\Poliklinik;
use App\User;

class LaporanFeeTindakanController extends Controller
{
    public function index(Request $request)
    {
        $data['tanggal_awal']   = $request->tanggal_awal ?? date('Y-m-d');
        $data['tanggal_akhir']  = $request->tanggal_akhir ?? date('Y-m-d');
        $data['poliklinik_id']  = $request->poliklinik_id;
        $data['perusahaan_asuransi_id']  = $request->perusahaan_asuransi_id;

        $awal                   = date('Y-m-d', strtotime($data['tanggal_awal']));
        $akhir                  = date('Y-m-d', strtotime($data['tanggal_akhir']));


        $search         = $request->input('search.value');
        $columns        = $request->get('columns');
        $pageSize       = ($request->length) ? $request->length : 10;
        $count_filter   = 0;


        $laporan = PendaftaranFeeTindakan::select(
            'pendaftaran.created_at as tanggal',
            'users.name as nama_pelaksana',
            'pendaftaran_fee_tindakan.pelaksana',
            'pendaftaran_fee_tindakan.jumlah_fee',
            'pendaftaran.kode as nomor_pendaftaran',
            'poliklinik.nama as unit',
            'perusahaan_asuransi.nama_perusahaan as jenis_pelayanan',
            'tindakan.tindakan as nama_tindakan'
        )
        ->join('nomor_antrian', 'nomor_antrian.pendaftaran_id', 'pendaftaran_fee_tindakan.pendaftaran_id')
        ->join('pendaftaran', 'pendaftaran.id', 'pendaftaran_fee_tindakan.pendaftaran_id')
        ->join('poliklinik', 'poliklinik.id', 'nomor_antrian.poliklinik_id')
        ->join('perusahaan_asuransi', 'perusahaan_asuransi.id', 'nomor_antrian.perusahaan_asuransi_id')
        ->join('tindakan', 'tindakan.id', 'pendaftaran_fee_tindakan.tindakan_id')
        ->join('users', 'users.id', 'pendaftaran_fee_tindakan.user_id')
        ->whereBetween(\DB::raw('left(nomor_antrian.created_at,10)'), [$awal,$akhir]);

        //$laporan = ViewPendaftaranFeeTindakan::whereBetween(\DB::raw('left(tanggal,10)'), [$awal,$akhir]);


        $count_total    = $laporan->count();
        $start          = ($request->start) ? $request->start : 0;
        $laporan->skip($start)->take($pageSize);

        if ($count_filter == 0) {
            $count_filter = $count_total;
        }

        if ($request->ajax()) {
            return DataTables::of($laporan)
            ->with([
                "recordsTotal" => $count_total,
                "recordsFiltered" => $count_filter,
                ])
            ->editColumn('tanggal', function ($row) {
                    return substr($row->tanggal, 0, 10);
            })
            ->rawColumns(['action','code'])
            ->addIndexColumn()
            ->make(true);
        }

        $data['poliklinik'] = Poliklinik::pluck('nama', 'id');
        $data['users']      = User::where('role', 'dokter')->pluck('name', 'id');
        return view('laporan-fee-tindakan.index', $data);
    }

    public function export_excel(Request $request)
    {
        return Excel::download(new LaporanFeeTindakanExport($request->tanggal_mulai, $request->tanggal_selesai, $request->user_id, $request->poliklinik_id), 'LaporanFeeTindakan.xlsx');
    }
}
