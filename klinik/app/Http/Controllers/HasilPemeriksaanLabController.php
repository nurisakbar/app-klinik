<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HasilPemeriksaanLab;

class HasilPemeriksaanLabController extends Controller
{
    public function store(Request $request)
    {
        if ($request->ajax()) {
            $input = $request->all();

            $isExist = HasilPemeriksaanLab::where('indikator_pemeriksaan_lab_id', $request->indikator_pemeriksaan_lab_id)
            ->where('pendaftaran_id', $request->pendaftaran_id)->first();

            if (isset($isExist)) {
                $isExist->hasil = $request->hasil;
                $isExist->save();
            } else {
                HasilPemeriksaanLab::create($input);
            }
            $data['listIndikator'] = HasilPemeriksaanLab::where('pendaftaran_id', $request->pendaftaran_id)->get();
            return view('pendaftaran.ajax-indikator-table', $data);
        }
    }

    public function show($pendaftaran_id)
    {
        $data['listIndikator'] = HasilPemeriksaanLab::where('pendaftaran_id', $pendaftaran_id)->get();
        return view('pendaftaran.ajax-indikator-table', $data);
    }

    public function update(Request $request, $id)
    {
        if ($this->isExist($id)) {
            HasilPemeriksaanLab::update(['id' => $id], $input);
        }
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = HasilPemeriksaanLab::findOrFail($id);
            $data->delete();
            return response()->json(['success' => true]);
        }
    }

    public function isExist($id)
    {
        if (HasilPemeriksaanLab::find($id) > 0) {
            return true;
        }

        return false;
    }
}
