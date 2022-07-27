<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\Akun;
use App\Http\Requests\AkunStoreRequest;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

class AkunController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Akun::all())
            ->addColumn('action', function ($row) {
                $btn = \Form::open(['url' => 'akun/' . $row->id, 'method' => 'DELETE', 'style' => 'float:right;margin-right:5px']);
                $btn .= "<button type='submit' class='btn btn-danger btn-sm'><i class='fa fa-trash' aria-hidden='true'></i></button>";
                $btn .= \Form::close();
                $btn .= '<a class="btn btn-danger btn-sm" href="/akun/' . $row->id . '/edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> ';
                return $btn;
            })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('akun.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('akun.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AkunStoreRequest $request)
    {
        Akun::create($request->all());
        return redirect(route('akun.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['akun'] = Akun::findOrFail($id);
        return view('akun.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['akun'] = Akun::findOrFail($id);
        return view('akun.edit', $data);
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
        $akun = Akun::findOrFail($id);
        $akun->update($request->all());
        return redirect(route('akun.index'))->with('message', 'Data Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $akun = akun::findOrFail($id);
        $akun->delete();
        return redirect(route('akun.index'))->with('message', 'Data Berhasil Dihapus');
    }

    public function import_excel(Request $request)
    {
        $file           = $request->file('file');
        $nama_file      = $file->getClientOriginalName();
        $file->move("uploads", $nama_file);
        $filePath = "uploads/" . $nama_file;
        $reader = ReaderEntityFactory::createXLSXReader();
        $reader->open($filePath);
        foreach ($reader->getSheetIterator() as $sheet) {
            $nomor = 1;
            $data = [];
            foreach ($sheet->getRowIterator() as $row) {
                if ($nomor > 1) {
                    $cells      = $row->getCells();
                    $params     = ['kode' => $cells[0]->getValue(),'nama' => $cells[1]->getValue()];
                    Akun::updateOrCreate($params, $params);
                }
                $nomor++;
            }
            return redirect('akun')->with('message', 'Import Data Akun Sedang Diproses ');
        }
    }
}
