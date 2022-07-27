<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\Kategori;
use App\Http\Requests\KategoriStoreRequest;

class KategoriController extends Controller
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
            $jenis_kategori = $this->jenis_kategori;
            return DataTables::of(Kategori::all())
            ->addColumn('jenis', function ($row) use ($jenis_kategori) {
                return $jenis_kategori[$row->jenis];
            })
            ->addColumn('action', function ($row) {
                $btn = \Form::open(['url' => 'kategori/' . $row->id, 'method' => 'DELETE','style' => 'float:right;margin-right:5px']);
                $btn .= "<button type='submit' class='btn btn-danger btn-sm'><i class='fa fa-trash' aria-hidden='true'></i></button>";
                $btn .= \Form::close();
                $btn .= '<a class="btn btn-danger btn-sm" href="/kategori/' . $row->id . '/edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                return $btn;
            })
            ->addColumn('aktif', function ($row) {
                return $row->aktif == 1 ? 'Aktif' : 'Tidak Aktif';
            })
            ->rawColumns(['action','code'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('kategori.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['jenis_kategori'] = $this->jenis_kategori;
        return view('kategori.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KategoriStoreRequest $request)
    {
        Kategori::create($request->all());
        return redirect(route('kategori.index'));
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
        $data['kategori'] = Kategori::findOrFail($id);
        $data['jenis_kategori'] = $this->jenis_kategori;
        return view('kategori.edit', $data);
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
        $kategoribiaya = Kategori::findOrFail($id);
        $kategoribiaya->update($request->all());
        return redirect(route('kategori.index'))->with('message', 'Data kategori biaya Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kategoribiaya = Kategori::findOrFail($id);
        $kategoribiaya->delete();
        return redirect(route('kategori.index'))->with('message', 'Data kategori biaya Berhasil Dihapus');
    }
}
