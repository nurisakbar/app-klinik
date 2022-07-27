<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\Models\NomorAntrian;
use App\Models\Pendaftaran;
use App\Models\Surat;
use DataTables;

class SuratController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Surat::with(['pendaftaran.pasien'])->get())
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-danger btn-sm" href="/surat/' . $row->id . '" target="_blank"><i class="fa fa-print" aria-hidden="true"></i></a> ';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('surat.index');
    }


    public function create(Request $request)
    {
        if ($request->jenis == 'surat_rujukan') {
            $jenis_surat = "SURAT_RUJUKAN";
        } elseif ($request->jenis == 'surat_buta_warna') {
            $jenis_surat = "SURAT_BUTA_WARNA";
        } elseif ($request->jenis == 'surat_sakit') {
            $jenis_surat = "SURAT_SAKIT";
        } else {
            $jenis_surat = "SURAT_SEHAT";
        }
        $data['jenis_surat'] = $jenis_surat;
        $data['pendaftaran'] = Pendaftaran::with('pasien')->where('id', $_GET['pendaftaran_id'])->first();
        $data['nomorAntrian'] = NomorAntrian::with('dokter')->where('pendaftaran_id', $_GET['pendaftaran_id'])->first();
        return view('surat.create', $data);
    }

    public function store(Request $request)
    {
        $surat = Surat::create($request->all());
        return redirect('surat/' . $surat->id);
    }

    public function show($id)
    {
        $data['surat'] = Surat::with('pendaftaran.pasien.wilayahAdministratifIndonesia', 'dokter')->find($id);
        $jenis = $data['surat']->jenis_surat == 'SURAT_SEHAT_SAKIT' ? 'surat_sakit' : $data['surat']->jenis_surat;
        // return view('surat.' . $jenis, $data);
        $pdf = PDF::loadView('surat.' . $jenis, $data);
        return $pdf->stream();
    }
}
