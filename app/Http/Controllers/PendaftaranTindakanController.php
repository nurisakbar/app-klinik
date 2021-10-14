<?php

namespace App\Http\Controllers;

use DataTables;
use Illuminate\Http\Request;
use App\Models\PendaftaranTindakan;
use App\Models\PendaftaranFeeTindakan;
use App\Models\Tindakan;
use App\Models\Pendaftaran;

class PendaftaranTindakanController extends Controller
{
    public function resumeTindakan(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(PendaftaranTindakan::where('pendaftaran_id', $request->pendaftaran_id)->with('tindakan')->get())
                ->addColumn('action', function ($row) {
                    return "<div class='btn btn-danger btn-sm' data-id = '" . $row->id . "' data-jenis='tindakan' onClick='removeItem(this)'>Hapus</div>";
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function addPendaftaranFeeTindakan($pendaftaran_fee_tindakan)
    {
        return PendaftaranFeeTindakan::create($pendaftaran_fee_tindakan);
    }

    public function resumeTambahTindakan(Request $request)
    {
        $pendaftaran = Pendaftaran::find($request->pendaftaran_id);
        $jenisPendaftaran = 'Umum'; //perlu ditanyakan jenis pendaftaran merefer kemana.

        $tindakan = Tindakan::find($request->tindakan_id);
        $listTarif = $tindakan->pembagian_tarif;
        $fee_tindakan = [];
        foreach($listTarif as $index => $item ){
            $jenis = explode('-', $index);
            if ($jenis[1] == $jenisPendaftaran){
                $fee_tindakan[$index] = $item;
            }
        }
        
        $user_id = [$request->dokter, $request->asisten];
        $pelaksana = ['Dokter', 'Asisten'];
        $jumlah_fee = [
            $fee_tindakan['dokter-'.$jenisPendaftaran], 
            $fee_tindakan['asisten_perawat-'.$jenisPendaftaran]
        ];

        $pendaftaran_fee_tindakan['tindakan_id'] = $request->tindakan_id;
        $pendaftaran_fee_tindakan['pendaftaran_id'] = $request->pendaftaran_id;
        $pendaftaran_fee_tindakan['jenis'] = $jenisPendaftaran;
        
        foreach($user_id as $index => $item){
            $pendaftaran_fee_tindakan['user_id'] = $item;
            $pendaftaran_fee_tindakan['pelaksana'] = $pelaksana[$index];
            $pendaftaran_fee_tindakan['jumlah_fee'] = $jumlah_fee[$index];
            $this->addPendaftaranFeeTindakan($pendaftaran_fee_tindakan);
        }

        PendaftaranTindakan::create($request->all());
        return view('pendaftaran.ajax-table-tindakan');
    }

    public function resumePilihTindakan(Request $request)
    {
        return PendaftaranTindakan::create($request->all());
    }

    public function resumeHapusTindakan($id)
    {
        $data = PendaftaranTindakan::findOrFail($id);
        $pendaftaran_id = $data->pendaftaran_id;
        $data->delete();

        PendaftaranFeeTindakan::where('pendaftaran_id', $pendaftaran_id)->where('tindakan_id', $id)->delete();

        return view('pendaftaran.ajax-table-tindakan');
    }
}
