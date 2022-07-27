<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\UnitStock;
use App\Models\PermintaanBarangInternal;
use App\Models\PermintaanBarangInternalDetail;
use App\Models\DistribusiStock;
use App\Models\Setting;
use DataTables;
use PDF;

class PermintaanBarangInternalController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(PermintaanBarangInternal::orderBy('id', 'DESC')->get())
                ->addColumn('action', function ($row) {
                    $btn = \Form::open(['route' => ['permintaan-barang-internal.destroy' , $row->id], 'method' => 'DELETE', 'style' => 'float:right;margin-right:5px']);
                    $btn .= "<button type='submit' class='btn btn-danger btn-sm'><i class='fa fa-trash' aria-hidden='true'></i></button>";
                    $btn .= \Form::close();
                    $btn .= '<a target="_blank" class="btn btn-danger btn-sm" href="/permintaan-barang-internal/cetak/' . $row->id . '" style="margin-right:5%;float:right"><i class="fa fa-print" aria-hidden="true"></i></a> ';
                    if ($row->status != 'Selesai') {
                        $btn .= '<a class="btn btn-danger btn-sm" href="/permintaan-barang-internal/verifikasi/' . $row->id . '" style="margin-right:5%;float:right"><i class="fa fa-eye" aria-hidden="true"></i></a> ';
                    }
                    return $btn;
                })
                ->editColumn('unit_stock_id_sumber', function ($row) {
                    return $row->unitSumber->nama_unit;
                })
                ->editColumn('unit_stock_id_tujuan', function ($row) {
                    return $row->unitTujuan->nama_unit;
                })
                ->addColumn('tanggal', function ($row) {
                    return tgl_indo($row->tanggal);
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('permintaan-barang-internal.index');
    }

    public function create()
    {
        $data['barang'] = Barang::pluck('nama_barang', 'id');
        $data['unitStock'] = UnitStock::pluck('nama_unit', 'id');
        return view('permintaan-barang-internal.create', $data);
    }

    public function destroy($id)
    {
        $data = PermintaanBarangInternal::findOrFail($id);
        PermintaanBarangInternalDetail::where('permintaan_barang_internal_id', $data->id)->delete();
        $data->delete();

        return redirect()->back();
    }

    public function store(Request $request)
    {

        $data = PermintaanBarangInternalDetail::where('permintaan_barang_internal_id', null)->get();

        if (count($data) == 0) {
            return redirect()->back()->with('message', 'Mohon pilih barang terlebih dahulu');
        } else {
            $request['status_po']   = 'pengajuan_po';
            $simpan_permintaan_barang_internal  = PermintaanBarangInternal::create($request->all());
            PermintaanBarangInternalDetail::where('permintaan_barang_internal_id', null)->update(['permintaan_barang_internal_id' => $simpan_permintaan_barang_internal->id]);
            $this->cetak($simpan_permintaan_barang_internal->id);
            return redirect('permintaan-barang-internal');
        }
    }

    public function cetak($id)
    {
        $data['setting'] = Setting::find(1);
        $data['permintaan_barang_internal'] = PermintaanBarangInternal::find($id);
        $data['permintaan_barang_detail'] = PermintaanBarangInternalDetail::where('permintaan_barang_internal_id', $data['permintaan_barang_internal']->id)->get();
        // return view('permintaan-barang-internal.cetak', $data);
        $pdf = PDF::loadView('permintaan-barang-internal.cetak', $data)->setPaper('A4');
        return $pdf->stream();
    }

    public function verifikasi($id)
    {
        $data['permintaan_barang'] = PermintaanBarangInternal::find($id);
        $data['barang'] = Barang::pluck('nama_barang', 'id');
        $data['unitStock'] = UnitStock::pluck('nama_unit', 'id');
        return view('permintaan-barang-internal.verifikasi', $data);
    }

    public function verify(Request $request, $id)
    {
        $permintaanBarang = PermintaanBarangInternal::find($id);
        foreach ($permintaanBarang->detail as $row) {
            $distribusiStock = DistribusiStock::where('unit_stock_id', $permintaanBarang->unitTujuan->id)
                ->where('barang_id', $row->barang_id)->first();
            if (!$distribusiStock) {
                $distribusiStock = new DistribusiStock();
            }
            $distribusiStock->unit_stock_id = $permintaanBarang->unitTujuan->id;
            $distribusiStock->barang_id = $row->barang_id;
            $distribusiStock->jumlah_stock += $row->jumlah_diterima;
            $distribusiStock->save();
        }
        $permintaanBarang->status = 'Selesai';
        $permintaanBarang->save();

        return redirect('permintaan-barang-internal');
    }
}
