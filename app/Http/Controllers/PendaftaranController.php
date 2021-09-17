<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use App\Models\Diagnosa;
use App\Models\Tindakan;
use App\Models\Obat;
use App\Models\Poliklinik;
use App\Models\Pasien;
use App\Models\PendaftaranResume;
use DataTables;
use PDF;

class PendaftaranController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Pendaftaran::with('pasien')->with('poliklinik')->get())
                ->addColumn('action', function ($row) {
                    $btn = \Form::open(['url' => 'pendaftaran/' . $row->id, 'method' => 'DELETE', 'style' => 'float:right;margin-right:75px']);
                    $btn .= "<button type='submit' class='btn btn-danger btn-sm'>Hapus</button>";
                    $btn .= \Form::close();
                    $btn .= '<a class="btn btn-danger btn-sm" href="/pendaftaran/' . $row->id . '/detail">Detail</a> ';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('pendaftaran.index');
    }

    public function pendaftaranCreate()
    {
        $data['poliklinik'] = Poliklinik::pluck('nama', 'id');
        $data['pasien'] = Pasien::pluck('nama', 'id');
        return view('pendaftaran.pasien-terdaftar', $data);
    }

    public function detailPasien(Request $request)
    {
        $data = Pasien::where('id', $request->id)->first();
        return $data;
    }

    public function pendaftaranInsert(Request $request)
    {
        $data = Pendaftaran::create($request->all());
        return redirect('/pendaftaran/'.$data->id.'/cetak');
    }

    public function detail($id)
    {
        $data['diagnosa'] = Diagnosa::all();
        $data['obat']     = Obat::all();
        $data['tindakan'] = Tindakan::all();
        $data['pasien']   = Pendaftaran::find($id);

        return view('pendaftaran.detail', $data);
    }

    public function cetak($id)
    {
        $data['pasien'] = Pendaftaran::find($id);
        return view('pendaftaran.nomor-antrian', $data);
    }

    public function print($id)
    {
        $data['pasien'] = Pendaftaran::find($id);
        $pdf = PDF::loadView('pendaftaran.cetak', $data);
        return $pdf->stream();
    }

    public function destroy($id)
    {
        $data = Pendaftaran::findOrFail($id);
        $data->delete();

        return redirect('/pendaftaran');
    }

    public function resumeDiagnosa(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(PendaftaranResume::where('jenis', 'diagnosa')->with('diagnosa')->get())
                ->addColumn('action', function ($row) {
                    $btn = \Form::open(['url' => 'resume/diagnosa/' . $row->id, 'method' => 'DELETE']);
                    $btn .= "<button type='submit' class='btn btn-danger btn-sm'>Hapus</button>";
                    $btn .= \Form::close();
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function resumePilihDiagnosa(Request $request)
    {
        $data = PendaftaranResume::create($request->all());
        return $data;
    }

    public function resumeHapusDiagnosa($id)
    {
        $data = PendaftaranResume::findOrFail($id);
        $data->delete();

        return redirect()->back();
    }

    public function resumeResep(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(PendaftaranResume::where('jenis', 'obat')->with('obat')->get())
                ->addColumn('action', function ($row) {
                    $btn = \Form::open(['url' => 'resume/resep/' . $row->id, 'method' => 'DELETE']);
                    $btn .= "<button type='submit' class='btn btn-danger btn-sm'>Hapus</button>";
                    $btn .= \Form::close();
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function resumePilihResep(Request $request)
    {
        $data = Obat::where('id', $request->id)->first();
        return $data;
    }

    public function resumeTambahResep(Request $request)
    {
        $data = PendaftaranResume::create($request->all());
        return $data;
    }

    public function resumeHapusResep($id)
    {
        $data = PendaftaranResume::findOrFail($id);
        $data->delete();

        return redirect()->back();
    }

    public function resumeTindakan(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(PendaftaranResume::where('jenis', 'tindakan')->with('tindakan')->get())
                ->addColumn('action', function ($row) {
                    $btn = \Form::open(['url' => 'resume/tindakan/' . $row->id, 'method' => 'DELETE']);
                    $btn .= "<button type='submit' class='btn btn-danger btn-sm'>Hapus</button>";
                    $btn .= \Form::close();
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function resumePilihTindakan(Request $request)
    {
        $data = PendaftaranResume::create($request->all());
        return $data;
    }

    public function resumeHapusTindakan($id)
    {
        $data = PendaftaranResume::findOrFail($id);
        $data->delete();

        return redirect()->back();
    }
}