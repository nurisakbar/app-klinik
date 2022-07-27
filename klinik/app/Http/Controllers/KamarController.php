<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Kamar;
use Illuminate\Http\Request;
use App\Http\Requests\KamarStoreRequest;

class KamarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Kamar::all())
                ->addColumn('action', function ($row) {
                    $btn = \Form::open(['url' => 'kamar/' . $row->id, 'method' => 'DELETE', 'style' => 'float:right;margin-right:5px']);
                    $btn .= "<button type='submit' class='btn btn-danger btn-sm'><i class='fa fa-trash' aria-hidden='true'></i></button>";
                    $btn .= \Form::close();
                    $btn .= '<a class="btn btn-danger btn-sm" href="/kamar/' . $row->id . '/edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> ';
                    return $btn;
                })
                ->rawColumns(['action', 'code'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('kamar.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('kamar.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KamarStoreRequest $request)
    {
        Kamar::create($request->all());
        return redirect(route('kamar.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['kamar'] = Kamar::findOrFail($id);
        return view('kamar.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['kamar'] = Kamar::findOrFail($id);
        return view('kamar.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(KamarStoreRequest $request, $id)
    {
        $kamar = Kamar::findOrFail($id);
        $kamar->update($request->all());
        return redirect(route('kamar.index'))->with('message', 'Data Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kamar = Kamar::findOrFail($id);
        $kamar->delete();
        return redirect(route('kamar.index'))->with('message', 'Data Berhasil Dihapus');
    }
}
