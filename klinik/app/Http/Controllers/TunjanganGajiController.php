<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\Models\KomponenGaji;
use App\Models\PegawaiTunjanganGaji;
use App\Http\Requests\TunjanganGajiStoreRequest;

class TunjanganGajiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(PegawaiTunjanganGaji::with('komponen_gaji')->where('pegawai_id', $request->pegawai_id)->get())
                ->addColumn('action', function ($row) {
                    $btn = \Form::open(['url' => 'tunjangan-gaji/' . $row->id, 'method' => 'DELETE', 'style' => 'float:right;margin-right:5px']);
                    $btn .= '<a class="btn btn-primary btn-sm" href="/tunjangan-gaji/' . $row->id . '/edit' . $row->role . '"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> ';
                    $btn .= "<button type='submit' class='btn btn-danger btn-sm'><i class='fa fa-trash' aria-hidden='true'></i></button>";
                    $btn .= \Form::close();
                    return $btn;
                })
                ->rawColumns(['action', 'code'])
                ->addIndexColumn()
                ->make(true);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TunjanganGajiStoreRequest $request)
    {
        PegawaiTunjanganGaji::create($request->all());
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['tunjangan_gaji'] = PegawaiTunjanganGaji::findOrFail($id);
        $data['komponen_gaji']  = KomponenGaji::pluck('nama_komponen', 'id');
        $data['pegawai']        = Pegawai::where('id', $data['tunjangan_gaji']->pegawai_id)->first();
        return view('tunjangan-gaji-pegawai.edit', $data);
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
        $tunjangan_gaji = PegawaiTunjanganGaji::findOrFail($id);
        $tunjangan_gaji->update($request->all());
        return redirect('pegawai/' . $tunjangan_gaji->pegawai_id . '?tab=komponen_gaji')->with('message', 'Data Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tunjangan_gaji = PegawaiTunjanganGaji::findOrFail($id);
        $tunjangan_gaji->delete();
        return redirect('pegawai/' . $tunjangan_gaji->pegawai_id . '?tab=komponen_gaji')->with('message', 'Data Berhasil Dihapus');
    }
}
