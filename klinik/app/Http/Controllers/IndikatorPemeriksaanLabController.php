<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IndikatorPemeriksaanLab;

class IndikatorPemeriksaanLabController extends Controller
{
    public function store(Request $request)
    {
        if ($request->ajax()) {
            $input = $request->all();

            $isExist = IndikatorPemeriksaanLab::where('nama_indikator', $request->nama_indikator)
            ->where('tindakan_id', $request->tindakan_id)->first();

            if (isset($isExist)) {
                $isExist->satuan = $request->satuan;
                $isExist->nilai_rujukan = $request->nilai_rujukan;
                $isExist->save();
            } else {
                IndikatorPemeriksaanLab::create($input);
            }
            $data['listIndikator'] = IndikatorPemeriksaanLab::where('tindakan_id', $request->tindakan_id)->get();
            return view('jenis-pemeriksaan-laboratorium.ajax-indikator-table', $data);
        }
    }

    public function show(Request $request, $id)
    {
        $data['listIndikator'] = IndikatorPemeriksaanLab::where('tindakan_id', $id)->get();
        return view('jenis-pemeriksaan-laboratorium.ajax-indikator-table', $data);
    }

    public function update(Request $request, $id)
    {
        if ($this->isExist($id)) {
            IndikatorPemeriksaanLab::update(['id' => $id], $input);
        }
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = IndikatorPemeriksaanLab::findOrFail($id);
            $data->delete();
            return response()->json(['success' => true]);
        }
    }

    public function isExist($id)
    {
        if (IndikatorPemeriksaanLab::find($id) > 0) {
            return true;
        }

        return false;
    }
}
