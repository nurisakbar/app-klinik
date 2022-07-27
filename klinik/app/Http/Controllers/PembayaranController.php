<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Http\Requests\PembayaranStoreRequest;
use App\Models\PendaftaranResep;
use App\Models\PendaftaranTindakan;
use PDF;
use Auth;
use App\Models\NomorAntrian;

class PembayaranController extends Controller
{
    public function index($id)
    {
        $data['metodePembayaran']   = ['cash' => 'Cash', 'transfer' => 'Transfer', 'debit' => 'Debit','piutang' => 'Piutang'];
        $data['nomorAntrian']       = NomorAntrian::with('pendaftaran.pasien', 'perusahaanAsuransi', 'poliklinik')->find($id);
        return view('pembayaran.index', $data);
    }

    public function store(PembayaranStoreRequest $request, $id)
    {
        $nomorAntrian = NomorAntrian::findOrFail($id);
        $nomorAntrian->update([
            'user_id_kasir'         => Auth::user()->id,
            'status_pembayaran'     => 1,
            'status_pelayanan'      => 'selesai',
            'metode_pembayaran'     => $request->metode_pembayaran,
            'jumlah_bayar'          => $request->jumlah_bayar,
            'keterangan_pembayaran' => $request->keterangan_pembayaran,
            'total_bayar'           => $request->total_bayar,
            'biaya_tambahan'        => $request->biaya_tambahan
        ]);

        //return redirect('pembayaran/' . $nomorAntrian->id . '/kwitansi');
        return redirect('pendaftaran?cetak_id=' . $nomorAntrian->id);
    }

    public function kwitansi($id)
    {
        $data['nomorAntrian'] = NomorAntrian::with('pendaftaran', 'perusahaanAsuransi')->findOrFail($id);
        $data['tindakans']      = PendaftaranTindakan::with('tindakan', 'pendaftaran')
                                ->where('pendaftaran_id', $data['nomorAntrian']->pendaftaran_id)
                                ->where('poliklinik_id', $data['nomorAntrian']->poliklinik_id)
                                ->get();

        $data['bhps']           = PendaftaranResep::with('barang')->where('jenis', 'bhp')
                                ->where('pendaftaran_id', $data['nomorAntrian']->pendaftaran_id)
                                ->where('poliklinik_id', $data['nomorAntrian']->poliklinik_id)
                                ->get();

        $data['nonRaciks']      = PendaftaranResep::with('barang')->where('jenis', 'non racik')
                                ->where('pendaftaran_id', $data['nomorAntrian']->pendaftaran_id)
                                ->where('poliklinik_id', $data['nomorAntrian']->poliklinik_id)
                                ->get();

        $data['obatRacik']      = \App\Models\PendaftaranObatRacik::with('detail.barang')
                                ->where('pendaftaran_id', $data['nomorAntrian']->pendaftaran_id)
                                ->where('poliklinik_id', $data['nomorAntrian']->poliklinik_id)
                                ->get();
        $pdf                    = PDF::loadView('pembayaran.kwitansi', $data)->setPaper('A5', 'landscape');
        return $pdf->stream();
    }
}
