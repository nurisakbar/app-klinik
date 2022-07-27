<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Http\Requests\SuratSakitStoreRequest;
use App\Http\Requests\SuratSehatStoreRequest;
use App\Models\Pasien;
use App\Models\PerusahaanAsuransi;
use App\Models\SuratSehatSakit;
use App\User;
use PDF;

class SuratSehatSakitController extends Controller
{
    protected $golongan_darah;

    public function __construct()
    {
        $this->golongan_darah      = config('datareferensi.golongan_darah');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(SuratSehatSakit::with(['pasien', 'user'])->get())
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-danger btn-sm" href="/surat-sehat-sakit/' . $row->id . '/print" target="_blank"><i class="fa fa-print" aria-hidden="true"></i></a> ';
                    return $btn;
                })
                ->addColumn('tanggal_mulai', function ($row) {
                    return tgl_indo($row->tanggal_mulai);
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('surat-sehat-sakit.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($tipe)
    {
        $data['golongan_darah'] = $this->golongan_darah;
        $data['tipe'] = $tipe;
        $data['pasien'] = Pasien::pluck('nama', 'id');
        $data['dokter'] = User::where('role', 'dokter')->pluck('name', 'id');
        return view('surat-sehat-sakit.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_surat_sehat(SuratSehatStoreRequest $request)
    {
        $surat_sehat = SuratSehatSakit::create(array_merge($request->all(), ['tipe_surat' => 'Surat Sehat']));
        return redirect('surat-sehat-sakit/' . $surat_sehat->id . '/print');
    }

    public function store_surat_sakit(SuratSakitStoreRequest $request)
    {
        SuratSehatSakit::create(array_merge($request->all(), ['tipe_surat' => 'Surat Sakit']));
        return redirect(route('surat-sehat-sakit.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('surat-sehat-sakit.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['kelompok_pegawai']   = $this->kelompokPegawai;
        $data['agama']              = $this->agama;
        $data['pegawai']            = Pegawai::findOrFail($id);
        return view('pegawai.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $pegawai->update($request->all());
        return redirect(route('pegawai.index'))->with('message', 'Data Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $pegawai->delete();
        return redirect(route('pegawai.index'))->with('message', 'Data Berhasil Dihapus');
    }

    /**
     * Print
     *
     * Cetak surat sehat sakit
     *
     * @return mixed
     */
    public function print($id)
    {
        $data['surat']      = SuratSehatSakit::with(['pasien'])->findOrFail($id);
        $dateOfBirth        = $data['surat']->pasien->tanggal_lahir;
        $today              = date('Y-m-d');
        $diff               = date_diff(date_create($dateOfBirth), date_create($today));
        $data['age'] = $diff->format('%y');

        if ($data['surat']->tipe_surat == 'surat sehat') {
            $pdf = PDF::loadView('surat-sehat-sakit.cetak-surat-sehat', $data);
        } else {
            $datediff = strtotime($data['surat']->tanggal_selesai) - strtotime($data['surat']->tanggal_mulai);

            $data['selama'] = round($datediff / (60 * 60 * 24));
            $pdf = PDF::loadView('surat-sehat-sakit.cetak-surat-sakit', $data);
        }
        return $pdf->stream();
    }
}
