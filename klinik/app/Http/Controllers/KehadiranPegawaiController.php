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
use App\Models\KelompokPegawai;

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
        $data['kelompok_pegawai']  = KelompokPegawai::pluck('nama_kelompok', 'id');
        $data['tanggal_awal']   = $request->tanggal_awal ?? date('Y-m-d');
        $data['tanggal_akhir']  = $request->tanggal_akhir ?? date('Y-m-d');
        $data['kelompok_pegawai_id'] = $request->kelompok_pegawai_id;

        if ($request->ajax()) {
            $detes = $this->displayDates($data['tanggal_awal'], $data['tanggal_akhir']);
            $defaultShift = Shift::firstOrCreate(['nama_shift' => 'Default'], ['jam_masuk' => '00:00','jam_pulang' => '00:00','toleransi_terlambat_masuk' => '0','toleransi_terlambat_pulang' => 0]);
            foreach ($detes as $date) {
            // cek datanya sudah ada atau belum
                foreach (Pegawai::all() as $p) {
                    $params = [
                        'jam_masuk'     =>  '00:00',
                        'jam_keluar'    =>  '00:00',
                        'scan_masuk'    =>  '00:00',
                        'scan_pulang'   =>  '00:00',
                        'status'        =>  'default',
                        'shift_id'      =>  $defaultShift->id
                    ];
                    KehadiranPegawai::firstOrCreate(['pegawai_id' => $p->id,'tanggal' => $date], $params);
                }
            }


            $kehadiran_pegawai = Pegawai::select('kehadiran_pegawai.*', 'pegawai.nama', 'pegawai.nip', 'shift.nama_shift')->leftJoin('kehadiran_pegawai', function ($join) {
                $start   = $_GET['tanggal_awal'] ?? date('Y-m-d');
                $end   = $_GET['tanggal_akhir'] ?? date('Y-m-d');

                $join->on('pegawai.id', '=', 'kehadiran_pegawai.pegawai_id');
                $join->whereBetween('kehadiran_pegawai.tanggal', [$start, $end]);
            })

                ->leftJoin('shift', function ($join) {
                    $join->on('shift.id', '=', 'kehadiran_pegawai.shift_id');
                })->get();


            if ($request->kelompok_pegawai_id) {
                $pegawai = Pegawai::where('kelompok_pegawai_id', $request->kelompok_pegawai_id)->first();
                $kehadiran_pegawai = $kehadiran_pegawai->where('pegawai_id', $pegawai->id);
            }

            $status_kehadiran = $this->status_kehadiran;

            return DataTables::of($kehadiran_pegawai)
                ->addColumn('action', function ($row) {
                    $btn = \Form::open(['url' => 'kehadiran-pegawai/' . $row->id . '', 'method' => 'DELETE', 'style' => 'float:right;margin-right:5px']);
                    $btn .= "<button type='submit' class='btn btn-danger btn-sm'><i class='fa fa-trash' aria-hidden='true'></i></button>";
                    $btn .= \Form::close();
                    $btn .= '<a class="btn btn-danger btn-sm" href="/kehadiran-pegawai/' . $row->id . '/edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> ';
                    return $btn;
                })
                ->addColumn('jam_masuk', function ($row) {
                    return (isset($row->jam_masuk)) ? $row->jam_masuk : '-';
                })
                ->addColumn('nama_shift', function ($row) {
                    return (isset($row->nama_shift)) ? $row->nama_shift : '-';
                })
                ->addColumn('jam_keluar', function ($row) {
                    return (isset($row->jam_keluar)) ? $row->jam_keluar : '-';
                })
                ->addColumn('tanggal', function ($row) {
                    return (isset($row->tanggal)) ? $row->tanggal : '-';
                })
                ->addColumn('status', function ($row) use ($status_kehadiran) {
                    return (isset($status_kehadiran[$row->status])) ? $status_kehadiran[$row->status] : '-';
                    ;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('kehadiran-pegawai.index', $data);
    }


    public function displayDates($date1, $date2, $format = 'Y-m-d')
    {
        $dates = array();
        $current = strtotime($date1);
        $date2 = strtotime($date2);
        $stepVal = '+1 day';
        while ($current <= $date2) {
            $dates[] = date($format, $current);
            $current = strtotime($stepVal, $current);
        }
        return $dates;
    }

    public function export_excel(Request $request)
    {
        return Excel::download(new KehadiranPegawaiExport($request->tanggal_mulai, $request->tanggal_selesai, $request->kelompok_pegawai_id), 'Kehadiran Pegawai.xlsx');
    }

    public function import_excel(Request $request)
    {
        $file               = $request->file('import_file');
        $filenameWithExt    = $request->file('import_file')->getClientOriginalName();
        $filename           = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension          = $request->file('import_file')->getClientOriginalExtension();
        $fileNameToStore    = $filename . '_' . time() . '.' . $extension;
        $path = $request->file('import_file')->storeAs('public/file-excel', $fileNameToStore);
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
        $data['shift']              = Shift::pluck('nama_shift', 'id');
        $data['pegawai']            = Pegawai::pluck('nama', 'id');
        $data['status']             = $this->status_kehadiran;
        $data['kehadiran_pegawai']  = KehadiranPegawai::findOrFail($id);
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
