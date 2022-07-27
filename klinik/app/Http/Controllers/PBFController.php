<?php

namespace App\Http\Controllers;

use DataTables;
use Illuminate\Http\Request;
use App\Models\PedagangBesarFarmasi;
use App\Http\Requests\PBFStoreRequest;

class PBFController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(PedagangBesarFarmasi::all())
                ->addColumn('action', function ($row) {
                    $btn = \Form::open(['url' => 'pbf/' . $row->id, 'method' => 'DELETE', 'style' => 'float:right;margin-right:5px']);
                    $btn .= "<button type='submit' class='btn btn-danger btn-sm'><i class='fa fa-trash' aria-hidden='true'></i></button>";
                    $btn .= \Form::close();
                    $btn .= '<a class="btn btn-danger btn-sm" href="/pbf/' . $row->id . '/edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> ';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('pbf.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pbf.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PBFStoreRequest $request)
    {
        PedagangBesarFarmasi::create($request->all());
        return redirect(route('pbf.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['pbf'] = PedagangBesarFarmasi::findOrFail($id);
        return view('pbf.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PBFStoreRequest $request, $id)
    {
        $pbf = PedagangBesarFarmasi::findOrFail($id);
        $pbf->update($request->all());
        return redirect(route('pbf.index'))->with('message', 'Data Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pbf = PedagangBesarFarmasi::findOrFail($id);
        $pbf->delete();
        return redirect(route('pbf.index'))->with('message', 'Data Berhasil Dihapus');
    }
}
