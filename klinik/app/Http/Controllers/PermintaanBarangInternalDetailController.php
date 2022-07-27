<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PermintaanBarangInternalDetail;
use App\Models\Barang;

class PermintaanBarangInternalDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->ajax()) {
            $input = $request->all();

            $isExist = PermintaanBarangInternalDetail::where('barang_id', $request->barang_id)
            ->where('permintaan_barang_internal_id', null)->first();

            if (isset($isExist)) {
                $isExist->jumlah_diminta += $request->jumlah_diminta;
                $isExist->save();
            } else {
                PermintaanBarangInternalDetail::create($input);
            }

            $data['permintaanBarangDetail'] = PermintaanBarangInternalDetail::where('permintaan_barang_internal_id', null)->get();
            return view('permintaan-barang-internal.ajax-table-detail', $data);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['permintaanBarangDetail'] = PermintaanBarangInternalDetail::where('permintaan_barang_internal_id', null)->get();
        return view('permintaan-barang-internal.ajax-table-detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = PermintaanBarangInternalDetail::findOrFail($id);
            $data->delete();
            return response()->json(['success' => true]);
        }
    }
}
