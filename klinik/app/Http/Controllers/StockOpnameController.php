<?php

namespace App\Http\Controllers;

use App\Exports\StockOpnameExport;
use App\Http\Requests\StockOpnameStoreRequest;
use App\Imports\StockOpnameImport;
use App\Models\Satuan;
use Illuminate\Http\Request;
use App\Models\StockOpname;
use DataTables;
use Maatwebsite\Excel\Facades\Excel;

class StockOpnameController extends Controller
{
    public function index(Request $request)
    {
        $data['tanggal']   = $request->tanggal ?? date('Y-m-d');
        if ($request->ajax()) {
            $stockOpname = StockOpname::with('barang')
                ->where('tanggal', $data['tanggal'])
                ->get();


            return DataTables::of($stockOpname)
                ->addColumn('satuan_terkecil', function ($row) {
                    return $row->barang->jumlah_satuan_terkecil . " " . $row->barang->satuanTerkecil->satuan;
                })
                ->addColumn('satuan_terbesar', function ($row) {
                    return $row->barang->jumlah_satuan_terbesar . " " . $row->barang->satuanTerbesar->satuan;
                })
                ->addColumn('tanggal', function ($row) {
                    return tgl_indo($row->tanggal);
                })
                ->addColumn('selisih', function ($row) {
                    return $row->stock_sebelumnya - $row->stock_real;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        if ($request->has('tanggal_mulai')) {
            if ($request->has('tanggal_akhir')) {
                return Excel::download(new StockOpnameExport($request->tanggal_mulai, $request->tanggal_selesai), 'Stock Opname.xlsx');
            }
        }

        return view('stock-opname.index', $data);
    }

    public function store(StockOpnameStoreRequest $request)
    {
        // menangkap file excel
        $file = $request->file('import_file');

        // membuat nama file unik
        $nama_file = $file->getClientOriginalName();

        // upload ke folder file_siswa di dalam folder public
        $file->move('file-excel', $nama_file);

        // import data
        try {
            Excel::import(new StockOpnameImport($request->tanggal), public_path('/file-excel/' . $nama_file));
            return redirect('/stock-opname')->with('message', 'Stock opname berhasil diimport!');
            ;
        } catch (\Throwable $th) {
            return redirect(route('stock-opname.index'))->with('message', 'Kode barang tidak ditemukan atau file excel tidak valid!');
        }
    }

    public function export_excel(Request $request)
    {
        return Excel::download(new StockOpnameExport($request->tanggal_mulai, $request->tanggal_selesai), 'Stock Opname.xlsx');
    }
}
