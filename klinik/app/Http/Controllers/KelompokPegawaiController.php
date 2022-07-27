<?php

namespace App\Http\Controllers;

use DataTables;
use Illuminate\Http\Request;
use App\Models\KelompokPegawai;
use App\Http\Requests\KelompokPegawaiStoreRequest;

class KelompokPegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(KelompokPegawai::all())
                ->addColumn('action', function ($row) {
                    $btn = \Form::open(['url' => 'kelompok-pegawai/' . $row->id, 'method' => 'DELETE', 'style' => 'float:right;margin-right:5px']);
                    $btn .= "<button type='submit' class='btn btn-danger btn-sm'><i class='fa fa-trash' aria-hidden='true'></i></button>";
                    $btn .= \Form::close();
                    $btn .= '<a class="btn btn-danger btn-sm" href="/kelompok-pegawai/' . $row->id . '/edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> ';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('kelompok-pegawai.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('kelompok-pegawai.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KelompokPegawaiStoreRequest $request)
    {
        KelompokPegawai::create($request->all());
        return redirect(route('kelompok-pegawai.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['kelompok_pegawai'] = KelompokPegawai::findOrFail($id);
        return view('kelompok-pegawai.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['kelompok_pegawai'] = KelompokPegawai::findOrFail($id);
        return view('kelompok-pegawai.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(KelompokPegawaiStoreRequest $request, $id)
    {
        $kelompok_pegawai = KelompokPegawai::findOrFail($id);
        $kelompok_pegawai->update($request->all());
        return redirect(route('kelompok-pegawai.index'))->with('message', 'Data Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kelompok_pegawai = KelompokPegawai::findOrFail($id);
        $kelompok_pegawai->delete();
        return redirect(route('kelompok-pegawai.index'))->with('message', 'Data Berhasil Dihapus');
    }
}
