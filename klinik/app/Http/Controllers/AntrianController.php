<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Antrian;
use DataTables;
use DB;
use App\Models\Poliklinik;

class AntrianController extends Controller
{
    public function dataAntrian($request)
    {
        return DataTables::of(Antrian::orderBy('id', 'DESC')->get())
            ->editColumn('created_at', function ($row) {
                return tgl_indo(date('Y-m-d', strtotime($row->created_at)));
            })
            ->editColumn('panggil', function ($row) {
                $btn = "<button class='btn btn-success btn-rounded' onClick='panggil(" . $row->nomor_antrian . ", " . $row->id . ")' > <i class='fa fa-microphone'></i> </button>";
                if ($row->status === 1) {
                    $btn =  "<button class='btn btn-success btn-rounded' disabled > <i class='fa fa-microphone'></i> </button>";
                }

                return $btn;
            })
            ->rawColumns(['panggil'])
            ->addIndexColumn()
            ->make(true);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->dataAntrian($request->all());
        }
        $data['nomorAntrian'] = $this->lastAntrian() + 1;
        return view('antrian.index', $data);
    }

    public function lastAntrian()
    {
        $lastAntrian = Antrian::whereDate('created_at', date('Y-m-d'))->orderBy('nomor_antrian', 'DESC')->first();
        if ($lastAntrian == null) {
            return 0;
        }

        return $lastAntrian->nomor_antrian;
    }

    public function store(Request $request)
    {
        $nomorAntrian = $this->lastAntrian() + 1;
        $request['nomor_antrian'] = $nomorAntrian;
        Antrian::create($request->all());

        return $nomorAntrian + 1;
    }

    public function show($id)
    {
        $data['detail'] = Antrian::detailAntrian()[0];
        return view('antrian.ajax-detail', $data);
    }

    public function update(Request $request, $id)
    {
        $antrian = Antrian::find($id);
        $antrian->status = $request->status;

        if ($antrian->save()) {
            return [
                'status' => true,
                'message' => 'Antrian berhasil diupdate'
            ];
        }

        return [
            'status' => failed,
            'message' => 'Antrian gagal diupdate'
        ];
    }


    public function antrianDepan()
    {
        $data['poliklinik'] = Poliklinik::all();
        return view('antrian.depan', $data);
    }
}
