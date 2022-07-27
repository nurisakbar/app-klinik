<?php

namespace App\Http\Controllers;

use DataTables;
use Illuminate\Http\Request;
use App\Models\PerusahaanAsuransi;
use App\Http\Requests\PerusahaanAsuransiStoreRequest;

class PerusahaanAsuransiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(PerusahaanAsuransi::all())
                ->addColumn('action', function ($row) {
                    $btn = \Form::open(['url' => 'perusahaan-asuransi/' . $row->id, 'method' => 'DELETE', 'style' => 'float:right;margin-right:5px']);
                    $btn .= "<button type='submit' class='btn btn-danger btn-sm'><i class='fa fa-trash' aria-hidden='true'></i></button>";
                    $btn .= \Form::close();
                    $btn .= '<a class="btn btn-danger btn-sm" href="/perusahaan-asuransi/' . $row->id . '/edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> ';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('perusahaan-asuransi.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('perusahaan-asuransi.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PerusahaanAsuransiStoreRequest $request)
    {
        PerusahaanAsuransi::create($request->all());
        return redirect(route('perusahaan-asuransi.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['perusahaan_asuransi'] = PerusahaanAsuransi::findOrFail($id);
        return view('perusahaan-asuransi.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['perusahaan_asuransi'] = PerusahaanAsuransi::findOrFail($id);
        return view('perusahaan-asuransi.edit', $data);
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
        $perusahaan_asuransi = PerusahaanAsuransi::findOrFail($id);
        $perusahaan_asuransi->update($request->all());
        return redirect(route('perusahaan-asuransi.index'))->with('message', 'Data Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $perusahaan_asuransi = PerusahaanAsuransi::findOrFail($id);
        $perusahaan_asuransi->delete();
        return redirect(route('perusahaan-asuransi.index'))->with('message', 'Data Berhasil Dihapus');
    }
}
