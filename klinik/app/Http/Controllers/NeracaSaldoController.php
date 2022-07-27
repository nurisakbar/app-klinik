<?php

namespace App\Http\Controllers;

use DB;
use DataTables;
use App\Models\Jurnal;
use Illuminate\Http\Request;
use App\Exports\NeracaSaldoExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\NeracaSaldoStoreRequest;

class NeracaSaldoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['periode'] = $request->periode ?? date('Y-m');

        $jurnal = Jurnal::with('akun')->groupBy('akun_id')->where('periode', $data['periode'])->get();
        if ($request->ajax()) {
            $collection = [];
            $i = 0;

            foreach ($jurnal as $j) {
                $debet = DB::table('jurnal')->select(DB::raw('SUM(nominal) as total'))
                    ->where('akun_id', $j->akun_id)
                    ->where('tipe', 'debet')
                    ->first();

                $credit = DB::table('jurnal')->select(DB::raw('SUM(nominal) as total'))
                    ->where('akun_id', $j->akun_id)
                    ->where('tipe', 'kredit')
                    ->first();


                $collection[$i]['id'] = $j->id;
                $collection[$i]['akun'] = $j->akun->nama;
                $collection[$i]['kode'] = $j->akun->kode;
                $collection[$i]['kredit'] = $credit->total;
                $collection[$i]['debet'] = $debet->total;

                $i++;
            }

            return DataTables::of($collection)
                ->addColumn('kredit', function ($row) {
                    return convert_rupiah($row['kredit']);
                })
                ->addColumn('debet', function ($row) {
                    return convert_rupiah($row['debet']);
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        if ($request->has('action')) {
            if ($request->action == 'download') {
                return Excel::download(new NeracaSaldoExport($request->periode), 'Laporan Neraca Saldo ' . date('F Y', strtotime($request->periode)) . '.xlsx');
            }
        }
        return view('neraca-saldo.index', $data);
    }
}
