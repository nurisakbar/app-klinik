<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Shift;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\Models\KehadiranPegawai;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KehadiranPegawaiExport;
use App\Imports\KehadiranPegawaiImport;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\KehadiranPegawaiStoreRequest;

class KehadiranPegawaiController extends Controller
{
    protected $status_kehadiran;

    public function __construct()
    {
        $this->status_kehadiran = config('datareferensi.status_kehadiran');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(KehadiranPegawai::with('pegawai')->get())
                ->addColumn('action', function ($row) {
                    $btn = \Form::open(['url' => 'kehadiran-pegawai/' . $row->id, 'method' => 'DELETE', 'style' => 'float:right;margin-right:5px']);
                    $btn .= "<button type='submit' class='btn btn-danger btn-sm'><i class='fa fa-trash' aria-hidden='true'></i></button>";
                    $btn .= \Form::close();
                    $btn .= '<a class="btn btn-danger btn-sm" href="/kehadiran-pegawai/' . $row->id . '/edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> ';
                    return $btn;
                })
                ->addColumn('tanggal', function ($row) {
                    return tgl_indo($row->tanggal);
                })
                ->addColumn('status', function ($row) {
                    return $row->status == 1 ? 'Hadir' : 'Tidak Hadir';
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        $data['tanggal_awal']   = $request->tanggal_awal ?? date('Y-m-d');
        $data['tanggal_akhir']  = $request->tanggal_akhir ?? date('Y-m-d');
        return view('kehadiran-pegawai.index', $data);
    }

    public function export_excel(Request $request)
    {
        return Excel::download(new KehadiranPegawaiExport($request->tanggal_mulai, $request->tanggal_selesai), 'Kehadiran Pegawai.xlsx');
    }

    public function import_excel(Request $request)
    {
        $file = $request->file('import_file');
        $path = Storage::putFile(
            'public/file-excel',
            $file
        );

        try {
            Excel::import(new KehadiranPegawaiImport(), $path);
            return redirect(route('kehadiran-pegawai.index'))->with('message', 'Data kehadiran pegawai berhasil diimport!');
        } catch (\Throwable $th) {
            return redirect(route('kehadiran-pegawai.index'))->with('message', 'File excel tidak valid!');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['shift'] = Shift::pluck('nama_shift', 'id');
        $data['status'] = $this->status_kehadiran;
        $data['pegawai'] = Pegawai::pluck('nama', 'id');
        return view('kehadiran-pegawai.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KehadiranPegawaiStoreRequest $request)
    {
        KehadiranPegawai::create($request->all());
        return redirect(route('kehadiran-pegawai.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['kehadiran_pegawai'] = KehadiranPegawai::findOrFail($id);
        return view('kehadiran-pegawai.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['pegawai'] = Pegawai::pluck('nama', 'id');
        $data['kehadiran_pegawai']            = KehadiranPegawai::findOrFail($id);
        return view('kehadiran-pegawai.edit', $data);
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
        $kehadiran_pegawai = KehadiranPegawai::findOrFail($id);
        $kehadiran_pegawai->update($request->all());
        return redirect(route('kehadiran-pegawai.index'))->with('message', 'Data Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kehadiran_pegawai = KehadiranPegawai::findOrFail($id);
        $kehadiran_pegawai->delete();
        return redirect(route('kehadiran-pegawai.index'))->with('message', 'Data Berhasil Dihapus');
    }
}
