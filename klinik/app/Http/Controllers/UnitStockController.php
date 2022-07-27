<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\UnitStock;
use App\Http\Requests\UnitStockStoreRequest;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use App\Models\DistribusiStock;
use App\Models\Poliklinik;
use App\Models\Barang;

class UnitStockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(UnitStock::all())
            ->addColumn('action', function ($row) {
                $btn = '<a class="btn btn-danger btn-sm" style="float:right;margin-right:5px" href="/stock/' . $row->id . '"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                $btn .= \Form::open(['url' => 'unit-stock/' . $row->id, 'method' => 'DELETE','style' => 'float:right;margin-right:5px']);
                $btn .= "<button type='submit' class='btn btn-danger btn-sm'><i class='fa fa-trash' aria-hidden='true'></i></button>";
                $btn .= \Form::close();
                $btn .= '<a class="btn btn-danger btn-sm" href="/unit-stock/' . $row->id . '/edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                return $btn;
            })
            ->rawColumns(['action','code'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('unit-stock.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('unit-stock.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UnitStockStoreRequest $request)
    {
        UnitStock::create($request->all());
        return redirect(route('unit-stock.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['unit_stock'] = UnitStock::findOrFail($id);
        return view('unit-stock.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UnitStockStoreRequest $request, $id)
    {
        $unit_stock = UnitStock::findOrFail($id);
        $unit_stock->update($request->all());
        return redirect(route('unit-stock.index'))->with('message', 'Data unit_stock biaya Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $unit_stock = UnitStock::findOrFail($id);
        $unit_stock->delete();
        return redirect(route('unit-stock.index'))->with('message', 'Data unit_stock biaya Berhasil Dihapus');
    }


    public function stockOpnameUnit(Request $request)
    {
        $file               = $request->file('file');
        $nama_file          = $file->getClientOriginalName();
        $destinationPath    = 'uploads';
        $file->move($destinationPath, $nama_file);
        $filePath = $destinationPath . '/' . $nama_file;
        $reader = ReaderEntityFactory::createXLSXReader();
        $reader->open($filePath);

        foreach ($reader->getSheetIterator() as $sheet) {
            $nomor = 1;
            foreach ($sheet->getRowIterator() as $row) {
                if ($nomor > 1) {
                    $cells                      = $row->getCells();
                    $nama_barang                = $cells[0]->getValue();
                    $barang                     = \App\Models\Barang::where('nama_barang', $nama_barang)->first();
                    $unit_stock                 = \App\Models\UnitStock::where('nama_unit', $cells[1]->getValue())->first();
                    $stock_baru                 = $cells[3]->getValue() ?? null;

                    // \Log::info($unit_stock);
                    // \Log::info($barang);
                    \Log::info($stock_baru);

                    if ($barang != null) {
                        if ($stock_baru != null) {
                            DistribusiStock::where('unit_stock_id', $unit_stock->id)
                                        ->where('barang_id', $barang->id)
                                        ->update(['jumlah_stock' => $stock_baru]);
                        }
                    }
                }
                $nomor++;
            }
        }

        return redirect('/stock/' . $request->unit_stock_id)->with('message', 'Proses Stock Opname Selesai');
    }

    public function sinkronisasi()
    {

        $unit_id =  \Request::segment(3);
        if ($unit_id != null) {
            foreach (Barang::select('id')->get() as $barang) {
                $params = ['barang_id' => $barang->id,'unit_stock_id' => $unit_id,'jumlah_stock' => 0];
                DistribusiStock::updateOrCreate(['barang_id' => $barang->id,'unit_stock_id' => $unit_id], $params);
            }
        } else {
            foreach (Poliklinik::where('unit_stock_id', '>', 0)->get() as $poliklinik) {
                foreach (Barang::select('id')->get() as $barang) {
                    $params = ['barang_id' => $barang->id,'unit_stock_id' => $poliklinik->unit_stock_id,'jumlah_stock' => 0];
                    DistribusiStock::updateOrCreate(['barang_id' => $barang->id,'unit_stock_id' => $poliklinik->unit_stock_id], $params);
                }
            }
        }


        return redirect('unit-stock')->with('message', 'Proses Sinkronisasi Selesai');
    }
}
