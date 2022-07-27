<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Bed;
use App\Models\Kamar;
use Illuminate\Http\Request;
use App\Http\Requests\BedStoreRequest;

class BedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Bed::with('kamar')->get())
                ->addColumn('status', function ($row) {
                    return $row->status == 1 ? 'Terisi' : 'Kosong';
                })
                ->addColumn('tarif', function ($row) {
                    return convert_rupiah($row->tarif);
                })
                ->addColumn('action', function ($row) {
                    $btn = \Form::open(['url' => 'bed/' . $row->id, 'method' => 'DELETE', 'style' => 'float:right;margin-right:5px']);
                    $btn .= "<button type='submit' class='btn btn-danger btn-sm'><i class='fa fa-trash' aria-hidden='true'></i></button>";
                    $btn .= \Form::close();
                    $btn .= '<a class="btn btn-danger btn-sm" href="/bed/' . $row->id . '/edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> ';
                    return $btn;
                })
                ->rawColumns(['action', 'code'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('bed.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['kamar'] = Kamar::pluck('nama_kamar', 'id');
        return view('bed.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BedStoreRequest $request)
    {
        Bed::create($request->all());
        return redirect(route('bed.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['bed'] = Bed::findOrFail($id);
        return view('bed.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['kamar'] = Kamar::pluck('nama_kamar', 'id');
        $data['bed'] = Bed::findOrFail($id);
        return view('bed.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BedStoreRequest $request, $id)
    {
        $bed = Bed::findOrFail($id);
        $bed->update($request->all());
        return redirect(route('bed.index'))->with('message', 'Data Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bed = Bed::findOrFail($id);
        $bed->delete();
        return redirect(route('bed.index'))->with('message', 'Data Berhasil Dihapus');
    }
}
