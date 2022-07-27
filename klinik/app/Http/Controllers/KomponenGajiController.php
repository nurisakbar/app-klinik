<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\KomponenGaji;
use App\Http\Requests\KomponenGajiStoreRequest;

class KomponenGajiController extends Controller
{
    protected $viewFolder = "komponen-gaji";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(KomponenGaji::all())
            ->addColumn('action', function ($row) {
                $btn = \Form::open(['url' => 'komponengaji/' . $row->id, 'method' => 'DELETE','style' => 'float:right;margin-right:5px']);
                $btn .= "<button type='submit' class='btn btn-danger btn-sm'><i class='fa fa-trash' aria-hidden='true'></i></button>";
                $btn .= \Form::close();
                $btn .= '<a class="btn btn-danger btn-sm" href="/komponengaji/' . $row->id . '/edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                return $btn;
            })
            ->rawColumns(['action','code'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('komponen-gaji.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('komponen-gaji.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KomponenGajiStoreRequest $request)
    {
        KomponenGaji::create($request->all());
        return redirect(route('komponengaji.index'));
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
        $data['komponengaji'] = KomponenGaji::findOrFail($id);
        return view('komponen-gaji.edit', $data);
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
        $komponengaji = KomponenGaji::findOrFail($id);
        $komponengaji->update($request->all());
        return redirect(route('komponengaji.index'))->with('message', 'Data Komponen Gaji Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $komponengaji = KomponenGaji::findOrFail($id);
        $komponengaji->delete();
        return redirect(route('komponengaji.index'))->with('message', 'Data Komponen Gaji Berhasil Dihapus');
    }
}
