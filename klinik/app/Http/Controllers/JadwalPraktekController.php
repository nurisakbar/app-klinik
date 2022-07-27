<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\JadwalPraktekStoreRequest;
use App\Models\JadwalPraktek;
use App\Models\Poliklinik;
use App\User;
use DataTables;

class JadwalPraktekController extends Controller
{
    protected $hari;

    public function __construct()
    {
        $this->hari         = config('datareferensi.hari');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $hari = $this->hari;
            return DataTables::of(JadwalPraktek::with('poliklinik')->where('user_id', $request->user_id)->get())
                ->addColumn('action', function ($row) {
                    $btn = \Form::open(['url' => 'jadwal-praktek/' . $row->id, 'method' => 'DELETE', 'style' => 'float:right;margin-right:5px']);
                    $btn .= '<a class="btn btn-primary btn-sm" href="/jadwal-praktek/' . $row->id . '/edit' . $row->role . '"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> ';
                    $btn .= "<button type='submit' class='btn btn-danger btn-sm'><i class='fa fa-trash' aria-hidden='true'></i></button>";
                    $btn .= \Form::close();
                    return $btn;
                })
                ->addColumn('hari', function ($row) use ($hari) {
                    return $hari[$row->hari];
                })
                ->rawColumns(['action', 'code'])
                ->addIndexColumn()
                ->make(true);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JadwalPraktekStoreRequest $request)
    {
        JadwalPraktek::create($request->all());
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['poliklinik'] = Poliklinik::pluck('nama', 'id');
        $data['hari']   = $this->hari;
        $data['jadwal_praktek'] = JadwalPraktek::findOrFail($id);
        $data['user'] = User::where('id', $data['jadwal_praktek']->user_id)->first();
        return view('jadwal-praktek.edit', $data);
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
        $jadwal_praktek = JadwalPraktek::findOrFail($id);
        $jadwal_praktek->update($request->all());
        return redirect('user/' . $jadwal_praktek->user_id)->with('message', 'Data Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $jadwal_praktek = JadwalPraktek::findOrFail($id);
        $jadwal_praktek->delete();
        return redirect('user/' . $jadwal_praktek->user_id)->with('message', 'Data Berhasil Dihapus');
    }
}
