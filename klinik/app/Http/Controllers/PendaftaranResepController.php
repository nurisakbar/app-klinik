<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\PendaftaranResep;
use App\Models\Pendaftaran;
use App\Models\CatatanBarangKeluar;
use App\Models\DistribusiStock;
use App\Models\Poliklinik;
use App\Models\NomorAntrian;

class PendaftaranResepController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pendaftaran = Pendaftaran::find($request->pendaftaran_id);
        $barang                         = Barang::find($request->barang_id);
        $request['is_bpjs']             = $pendaftaran->perusahaanAsuransi->nama_perusahaan == 'BPJS' ? true : false;
        $request['jenis']               = 'non racik';
        $request['harga']               = $barang->harga_jual;
        $request['pendaftaran_id']      = $request->pendaftaran_id;
        $request['poliklinik_id']       = $request->poliklinik_id;
        $request['satuan_terkecil_id']  = $request->satuan;
        $pendaftaranResep = PendaftaranResep::create($request->all());

        // kurangi stock pada poli yang bersangkutan
        $poliklinik = Poliklinik::find(\Auth::user()->poliklinik_id);
        $stock = DistribusiStock::where('barang_id', $request->barang_id)
        ->where('unit_stock_id', $poliklinik->unit_stock_id)
        ->first();
        $newStock = $stock->jumlah_stock - $request->jumlah;
        $stock->update(['jumlah_stock' => $newStock]);

        CatatanBarangKeluar::create([
            'barang_id'                     =>  $request->barang_id,
            'qty'                           =>  $request->jumlah,
            'perusahaan_penjamin_id'        =>  $pendaftaran->perusahaanAsuransi->id,
            'harga_jual'                    =>  $barang->harga_jual,
            'harga_modal'                   =>  $barang->harga,
            'relation_id'                   =>  $pendaftaranResep->id
        ]);
        return $pendaftaranResep;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['nomorAntrian']     = NomorAntrian::find($id);
        $data['pendaftaranResep'] = PendaftaranResep::with(['barang.satuanTerkecil'])
        ->where('jenis', '!=', 'bhp')
        ->where('poliklinik_id', $data['nomorAntrian']->poliklinik_id)
        ->where('pendaftaran_id', $data['nomorAntrian']->pendaftaran_id);
        return view('pendaftaran.partials.daftar_resep', $data);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pendaftaranResep = PendaftaranResep::findOrFail($id);
        // kembalikan stock
        $poliklinik = Poliklinik::find($pendaftaranResep->poliklinik_id);
        $stock = DistribusiStock::where('barang_id', $pendaftaranResep->barang_id)
        ->where('unit_stock_id', $poliklinik->unit_stock_id)
        ->first();
        if ($stock != null) {
            $newStock = $stock->jumlah_stock + $pendaftaranResep->jumlah;
            $stock->update(['jumlah_stock' => $newStock]);
        }
        $pendaftaranResep->delete();
    }

    public function index()
    {
        return PendaftaranResep::with('barang')->find($_GET['id']);
    }

    public function update($id, Request $request)
    {
        $pendaftaranResep = PendaftaranResep::find($id);
        $pendaftaranResep->update($request->all());
        return $pendaftaranResep;
    }
}
