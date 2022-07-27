<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\Akun;

class BukuBesarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Akun::all())
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-danger btn-sm" href="/buku-besar/periode/' . $row->kode . '"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                    return $btn;
                })
                ->addColumn('aktif', function ($row) {
                    return $row->aktif == 1 ? 'Aktif' : 'Tidak Aktif';
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('buku-besar.index');
    }

    public function show_periode($kode)
    {
        $data['kode'] = $kode;
        $data['akun'] = Akun::with('jurnal')->where('kode', $kode)->first();
        $data['dates'] = \DB::table('jurnal')
            ->distinct()
            ->orderBy('tanggal')
            ->get([
                \DB::raw('YEAR(`tanggal`) AS `year`'),
                \DB::raw('MONTH(`tanggal`) AS `month`'),
            ]);
        return view('buku-besar.show-periode', $data);
    }

    public function show($kode)
    {
        $data['akun'] = Akun::with('jurnal')->where('kode', $kode)->first();
        $dates = \DB::table('jurnal')
            ->distinct()
            ->orderBy('tanggal')
            ->get([
                \DB::raw('YEAR(`tanggal`) AS `year`'),
                \DB::raw('MONTH(`tanggal`) AS `month`'),
            ]);
        return view('buku-besar.show', $data);
    }
}
