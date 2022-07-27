<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\Akun;
use App\Models\Jurnal;
use App\Http\Requests\JurnalStoreRequest;

class JurnalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['tanggal_awal']       = $request->tanggal_awal ?? date('Y-m-d');
        $data['tanggal_akhir']      = $request->tanggal_akhir ?? date('Y-m-d');
        if ($request->ajax()) {
            return DataTables::of(Jurnal::with('akun')->get())
                ->addColumn('action', function ($row) {
                    $btn = \Form::open(['url' => 'jurnal/' . $row->id, 'method' => 'DELETE', 'style' => 'float:right;margin-right:5px']);
                    $btn .= "<button type='submit' class='btn btn-danger btn-sm'><i class='fa fa-trash' aria-hidden='true'></i></button>";
                    $btn .= \Form::close();
                    $btn .= '<a class="btn btn-danger btn-sm" href="/jurnal/' . $row->id . '/edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> ';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        $data['akunList'] = Akun::pluck('nama', 'id');
        $data['jurnals'] = Jurnal::with('akun')->get();
        $data['periode'] = \DB::select("select DISTINCT(tanggal) as tanggal from jurnal where tanggal between '" . $data['tanggal_awal'] . "' and '" . $data['tanggal_akhir'] . "'");
        return view('jurnal.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['periode'] = date('Y-m');
        $data['akunList'] = Akun::pluck('nama', 'id');
        return view('jurnal.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $index = count($request->tanggal) - 1;
        $user_id = \Auth::user()->id;
        for ($i = 0; $i <= $index; $i++) {
            $data = [
                'user_id' => $user_id,
                'tanggal' => $request->tanggal[$i],
                'akun_id' => $request->akun_id[$i],
                'nominal' => $request->nominal[$i],
                'keterangan' => $request->keterangan[$i],
                'tipe' => $request->tipe[$i],
                'periode' => $request->periode,
            ];
            Jurnal::create($data);
        }

        return redirect(route('jurnal.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['jurnal'] = Jurnal::findOrFail($id);
        return view('jurnal.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['jurnal'] = Jurnal::findOrFail($id);
        $data['akunList'] = Akun::pluck('nama', 'id');
        return view('jurnal.edit', $data);
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
        $jurnal = Jurnal::findOrFail($id);
        $jurnal->update($request->all());
        return redirect(route('jurnal.index'))->with('message', 'Data Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $jurnal = Jurnal::findOrFail($id);
        $jurnal->delete();
        return redirect(route('jurnal.index'))->with('message', 'Data Berhasil Dihapus');
    }

    public function add_form()
    {
        $data['akunList'] = Akun::pluck('nama', 'id');
        $data['id'] = rand(1, 1000);
        return view('jurnal.form_child', $data);
    }
}
