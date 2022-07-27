<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\TbmIcd;
use App\Models\PendaftaranDiagnosa;

class DiagnosaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(TbmIcd::all())
                ->addIndexColumn()
                ->make(true);
        }
        return view('diagnosa.index');
    }

    public function riwayatDiagnosa(Request $request)
    {
        $riwayatDiagnosa = PendaftaranDiagnosa::with('icd')->where('pendaftaran_id', $request->id)->get();

        if ($request->ajax()) {
            return DataTables::of($riwayatDiagnosa)
                ->addIndexColumn()
                ->make(true);
        }
    }
}
