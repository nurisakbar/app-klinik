<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\Poliklinik;
use App\Http\Requests\PoliklinikStoreRequest;
use App\Models\UnitStock;
use App\Models\Barang;
use App\Models\DistribusiStock;

class PoliklinikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Poliklinik::with('unitStock')->get())
            ->addColumn('aktif', function ($row) {
                return $row->aktif == 1 ? 'Aktif' : 'Tidak Aktif';
            })
            ->addColumn('action', function ($row) {
                $btn = \Form::open(['url' => 'poliklinik/' . $row->id, 'method' => 'DELETE','style' => 'float:right;margin-right:5px']);
                $btn .= "<button type='submit' class='btn btn-danger btn-sm'><i class='fa fa-trash' aria-hidden='true'></i></button>";
                $btn .= \Form::close();
                $btn .= '<a class="btn btn-danger btn-sm" href="/poliklinik/' . $row->id . '/edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> ';
                return $btn;
            })
            ->rawColumns(['action','code'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('poliklinik.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['unit_stock'] = UnitStock::pluck('nama_unit', 'id');
        return view('poliklinik.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PoliklinikStoreRequest $request)
    {
        $poliklinik = Poliklinik::create($request->all());
        // distribusi stock
        foreach (Barang::all() as $barang) {
            $params = ['barang_id' => $barang->id,'unit_stock_id' => $request->unit_stock_id,'poliklinik_id' => $poliklinik->id,'jumlah_stock' => 400];
            DistribusiStock::firstOrCreate($params, $params);
        }
        return redirect(route('poliklinik.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['poliklinik'] = Poliklinik::findOrFail($id);
        $data['unit_stock'] = UnitStock::pluck('nama_unit', 'id');
        return view('poliklinik.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['poliklinik'] = Poliklinik::findOrFail($id);
        $data['unit_stock'] = UnitStock::pluck('nama_unit', 'id');
        return view('poliklinik.edit', $data);
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
        $poliklinik = Poliklinik::findOrFail($id);
        $poliklinik->update($request->all());
        foreach (Barang::select('id')->get() as $barang) {
            $params = ['barang_id' => $barang->id,'unit_stock_id' => $request->unit_stock_id,'jumlah_stock' => 400];
            $where  = ['barang_id' => $barang->id,'unit_stock_id' => $request->unit_stock_id];
            DistribusiStock::firstOrCreate($where, $params);
        }
        return redirect(route('poliklinik.index'))->with('message', 'Data Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $poliklinik = poliklinik::findOrFail($id);
        $poliklinik->delete();
        return redirect(route('poliklinik.index'))->with('message', 'Data Berhasil Dihapus');
    }
}
