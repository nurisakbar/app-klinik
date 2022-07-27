<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Diagnosa;
use App\Models\PendaftaranDiagnosa;
use App\Models\NomorAntrian;

class PendaftaranDiagnosaController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request['pendaftaran_id']  = $request->pendaftaran_id;
        $request['poliklinik_id']   = $request->poliklinik_id;
        return PendaftaranDiagnosa::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['nomorAntrian']           = NomorAntrian::find($id);
        $data['pendaftaranDiagnosa']    = PendaftaranDiagnosa::with(['icd'])
                                        ->where('pendaftaran_id', $data['nomorAntrian']->pendaftaran_id)
                                        ->where('poliklinik_id', $data['nomorAntrian']->poliklinik_id);
        return view('pendaftaran.partials.daftar_diagnosa', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = PendaftaranDiagnosa::findOrFail($id);
        $data->delete();
    }
}
