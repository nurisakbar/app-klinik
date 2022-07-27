<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\PengeluaranOperasional;
use App\Http\Requests\KategoriStoreRequest;

class PengeluaranOperasionalController extends Controller
{
    protected $jenis_kategori;


    public function __construct()
    {
        $this->jenis_kategori    = config('datareferensi.jenis_kategori');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(PengeluaranOperasional::all())
            ->addColumn('action', function ($row) {
                $btn = \Form::open(['url' => 'pengeluaran/' . $row->id, 'method' => 'DELETE','style' => 'float:right;margin-right:5px']);
                $btn .= "<button type='submit' class='btn btn-danger btn-sm'><i class='fa fa-trash' aria-hidden='true'></i></button>";
                $btn .= \Form::close();
                $btn .= '<a class="btn btn-danger btn-sm" href="/pengeluaran/' . $row->id . '/edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                return $btn;
            })
            ->rawColumns(['action','code'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('pengeluaran.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['jenis_kategori'] = $this->jenis_kategori;
        return view('pengeluaran.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        PengeluaranOperasional::create($request->all());
        return redirect(route('pengeluaran.index'));
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
        $data['pengeluaran'] = PengeluaranOperasional::findOrFail($id);
        return view('pengeluaran.edit', $data);
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
        $pengeluaran = PengeluaranOperasional::findOrFail($id);
        $pengeluaran->update($request->all());
        return redirect(route('pengeluaran.index'))->with('message', 'Data kategori biaya Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pengeluaran = PengeluaranOperasional::findOrFail($id);
        $pengeluaran->delete();
        return redirect(route('pengeluaran.index'))->with('message', 'Data kategori biaya Berhasil Dihapus');
    }
}
