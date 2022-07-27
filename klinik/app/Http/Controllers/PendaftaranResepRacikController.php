<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Satuan;
use App\Models\PendaftaranObatRacik;
use App\Models\PendaftaranObatRacikDetail;
use Session;
use App\Models\Pendaftaran;
use App\Models\CatatanBarangKeluar;
use App\Models\DistribusiStock;
use App\Models\Poliklinik;
use App\Models\NomorAntrian;

class PendaftaranResepRacikController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $jml_item_obat = count($request->jumlah_kemasan);
        for ($i = 1; $i <= $jml_item_obat; $i++) {
            $dataObatRacik = [
                'pendaftaran_id' => $request->pendaftaran_id,
                'jumlah_kemasan' => $request->jumlah_kemasan[$i][0],
                'aturan_pakai' => $request->aturan_pakai[$i][0],
                'poliklinik_id' => $request->poliklinik_id,
                'kemasan' => $request->jenis_kemasan[$i][0]
            ];
            $pendaftaran = Pendaftaran::findOrFail($request->pendaftaran_id);
            $pendaftaranObatRacik = PendaftaranObatRacik::create($dataObatRacik);
            $barang = $request->barang_id[$i];
            $index = 0;
            foreach ($barang as $item) {
                $baramItem = Barang::findOrFail((int)$request->barang_id[$i][$index]);
                $detailData = [
                    'pendaftaran_obat_racik_id' => $pendaftaranObatRacik->id,
                    'harga' => $baramItem->harga_jual,
                    'barang_id' => (int)$request->barang_id[$i][$index],
                    'jumlah' => (int)$request->jumlah[$i][$index],
                ];
                $obatRacikDetail = PendaftaranObatRacikDetail::create($detailData);

                // kurangi stock pada poli yang bersangkutan
                $poliklinik = Poliklinik::find(\Auth::user()->poliklinik_id);
                $stock = DistribusiStock::where('barang_id', (int)$request->barang_id[$i][$index])
                ->where('unit_stock_id', $poliklinik->unit_stock_id)
                ->first();
                $newStock = $stock->jumlah_stock - (int)$request->jumlah[$i][$index];
                $stock->update(['jumlah_stock' => $newStock]);


                CatatanBarangKeluar::create([
                    'barang_id'                     =>  (int)$request->barang_id[$i][$index],
                    'qty'                           =>  (int)$request->jumlah[$i][$index],
                    'perusahaan_penjamin_id'        =>  $pendaftaran->perusahaanAsuransi->id,
                    'harga_jual'                    =>  $baramItem->harga_jual,
                    'harga_modal'                   =>  $baramItem->harga,
                    'relation_id'                   =>  $obatRacikDetail->id
                ]);

                //return $detailData;


                $index++;
            }
        }
        if ($request->page == 'ondotogram') {
            $nomorAntrian = \App\Models\NomorAntrian::where('pendaftaran_id', $request->pendaftaran_id)->where('poliklinik_id', $request->poliklinik_id)->first();
            return redirect('ondotogram/' . $nomorAntrian->id);
        }
        return redirect('pendaftaran/' . $request->nomor_antrian_id . '/pemeriksaan');
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
        $data['pendaftaranResepRacik'] = PendaftaranObatRacik::with('detail.barang')
                                        ->where('pendaftaran_id', $data['nomorAntrian']->pendaftaran_id)
                                        ->where('poliklinik_id', $data['nomorAntrian']->poliklinik_id);
        return view('pendaftaran.partials.daftar_resep_racik', $data);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pendaftaranResep = PendaftaranObatRacik::findOrFail($id);

        $obatRacikDetail = PendaftaranObatRacikDetail::where('pendaftaran_obat_racik_id', $id)->get();
        foreach ($obatRacikDetail as $obat) {
        // kembalikan stock
            $poliklinik = Poliklinik::find(\Auth::user()->poliklinik_id);
            $stock = DistribusiStock::where('barang_id', $obat->barang_id)
            ->where('unit_stock_id', $poliklinik->unit_stock_id)
            ->first();
            $newStock = $stock->jumlah_stock + $obat->jumlah;
            $stock->update(['jumlah_stock' => $newStock]);
        }

        $pendaftaranResep->delete();
    }

    public function addKomposisi(Request $request)
    {
        $data['barang'] = Barang::pluck('nama_barang', 'id');
        $data['komposisi_item'] = rand(2, 1000);
        $data['id'] = $request->id;
        return view('pendaftaran.partials.add_komposisi_form', $data);
    }

    public function addObatRacikForm(Request $request)
    {
        $index_table = Session::get('index_table') == null ? 2 : Session::get('index_table') + 1;
        $data['barang'] = Barang::pluck('nama_barang', 'id');
        $data['table_item'] = rand(2, 1000);
        $data['id'] = $index_table;
        $data['satuan']             = Satuan::pluck('satuan', 'id');
        return view('pendaftaran.partials.add_obat_racik_form', $data);
    }


    public function index(Request $request)
    {
        return PendaftaranObatRacik::find($_GET['id']);
    }

    public function update($id, Request $request)
    {
        $pendaftaranObatRacik = PendaftaranObatRacik::find($id);
        $pendaftaranObatRacik->update($request->all());
        return $pendaftaranObatRacik;
    }
}
