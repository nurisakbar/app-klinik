<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RujukanInternal;
use App\Models\Pendaftaran;
use DataTables;
use App\Models\NomorAntrian;
use App\Models\PendaftaranFeeTindakan;
use App\Models\TindakanBHP;
use App\Models\Tindakan;
use App\Models\Barang;
use App\Models\PendaftaranResep;
use App\Models\PendaftaranTindakan;
use Auth;
use App\Models\PendaftaranTindakanTemp;

class PendaftaranRujukanLabController extends Controller
{
    public function store(Request $request)
    {
        $pendaftaran                = Pendaftaran::find($request->pendaftaran_id);
        $pasien = \DB::table('pasien')->where('id', $pendaftaran->pasien_id)->first();

        // MEMCATAT NOTIFIKASI
        \DB::table('notifikasi')->insert([
            'status_baca'       =>  0,
            'poliklinik_id'     =>  $request->poliklinik_id,
            'notifikasi_judul'  =>  'Hasil Pemeriksaan Lab',
            'notifikasi_pesan'  =>  $pasien->nama,
            'created_at'        => now(),
            'updated_at'        => now(),
            'pasien_id'         => $pasien->id,
            'display'           => 0,
            'user_id'           =>  session('user_id')
        ]);

        $request['users_id']        = $request->user_id;
        $request['pasien_id']       = $pendaftaran->pasien_id;
        $request['pendaftaran_id']  = $pendaftaran->id;
        $request['tindakan_id']     = $request->jenis_pemeriksaan_laboratorium_id;
        $request['catatan']         = $request->catatan;
        $request['status']          = "Proses Pemeriksaan";
        RujukanInternal::create($request->all());
                // create nomor antrian
        $nomor = NomorAntrian::where('poliklinik_id', $request->poliklinik_id)
                ->whereDate('created_at', date('Y-m-d'))
                ->max('nomor_antrian');
                $nomorAntrianData = [
                'pendaftaran_id'    =>  $request->pendaftaran_id,
                'poliklinik_id'     =>  $request->poliklinik_id,
                'nomor_antrian'     =>  ($nomor + 1),
                'status_pelayanan'  => 'selesai_pemeriksaan_medis',
                'dokter_id'         => $request->user_id,
                'perusahaan_asuransi_id' => $pendaftaran->perusahaan_asuransi_id,
                'tindakan_id'       => $request->jenis_pemeriksaan_laboratorium_id,
                ];
                NomorAntrian::create($nomorAntrianData);
                $pendaftaran->save();

        // tambah fee pemeriksaan dokter
                $request['tindakan_id'] = 162; // 162 tindakan untuk pemeriksaan dokter
                $this->store_tindakan($request);

                $tindakanTemp = PendaftaranTindakanTemp::where('pasien_id', $request->pasien_id)->get();
                foreach ($tindakanTemp as $row) {
                    $request['tindakan_id'] = $row->tindakan_id;
                    $this->store_tindakan($request);
                    PendaftaranTindakanTemp::find($row->id)->delete();
                }
    }

        // simpan tindakan langsung dari pendaftaran
    public function store_tindakan($request)
    {

        $pendaftaran        = Pendaftaran::with('perusahaanAsuransi')->find($request->pendaftaran_id);
        $tindakan           = Tindakan::find($request->tindakan_id);

        $request['poliklinik_id'] = $request->poliklinik_id;

        // apakah umum, BPJS atau lain
        $jenisPendaftaran   =  strtolower($pendaftaran->perusahaanAsuransi->nama_perusahaan);
        if (!in_array($jenisPendaftaran, ['bpjs','umum'])) {
            $jenisPendaftaran = 'perusahaan';
        }
        $listTarif      = $tindakan->pembagian_tarif;

        $fee_tindakan = [];
        foreach ($listTarif as $index => $item) {
            $jenis = explode('-', $index);
            if ($jenis[1] == $jenisPendaftaran) {
                $fee_tindakan[$index] = $item;
            }
        }

        // Pemberian Fee Untuk Dokter

        $pendaftaranFeeTindakan = PendaftaranFeeTindakan::create([
            'tindakan_id'       =>  $request->tindakan_id,
            'pendaftaran_id'    =>  $request->pendaftaran_id,
            'poliklinik_id'     =>  $request->poliklinik_id ?? 0,
            'jumlah_fee'        =>  $fee_tindakan['dokter-' . $jenisPendaftaran],
            'user_id'           =>  $request->dokter,
            'pelaksana'         => 'Dokter'
        ]);

        // Pemberian fee Untuk Klinik
        $pendaftaranFeeTindakan = PendaftaranFeeTindakan::create([
            'tindakan_id'       =>  $request->tindakan_id,
            'pendaftaran_id'    =>  $request->pendaftaran_id,
            'poliklinik_id'     =>  $request->poliklinik_id ?? 0,
            'jumlah_fee'        =>  $fee_tindakan['klinik-' . $jenisPendaftaran],
            'pelaksana'         => 'Klinik'
        ]);

        // Pemberian Fee Untuk Asisten
        if ($request->asisten != null) {
            $pendaftaranFeeTindakan = PendaftaranFeeTindakan::create([
                'tindakan_id'       =>  $request->tindakan_id,
                'pendaftaran_id'    =>  $request->pendaftaran_id,
                'poliklinik_id'     =>  $request->poliklinik_id ?? 0,
                'jumlah_fee'        =>  $fee_tindakan['asisten-' . $jenisPendaftaran],
                'user_id'           =>  $request->asisten,
                'pelaksana'         => 'Asisten'
            ]);
        }


        // input BHP yang digunakan ketika tindakan
        $tindakanBHP = TindakanBHP::where('tindakan_id', $request->tindakan_id)->get();
        foreach ($tindakanBHP as $item) {
            $barang = Barang::find($item->barang_id);
            if ($barang != null) {
                PendaftaranResep::create([
                    'pendaftaran_id'        =>  $request->pendaftaran_id,
                    'barang_id'             =>  $item->barang_id,
                    'jumlah'                =>  $item->jumlah,
                    'satuan_terkecil_id'    =>  $barang->satuan_terkecil_id,
                    'aturan_pakai'          =>  '-',
                    'jenis'                 =>  'bhp',
                    'poliklinik_id'         =>  $request->poliklinik_id,
                    'tindakan_id'           => $request->tindakan_id,
                    'harga'                 =>  $barang->harga_jual,
                ]);
            }
        }
        $request['fee'] = $tindakan['tarif_' . strtolower($jenisPendaftaran)];
        $request['qty'] = 1;

        // cek apakah tindakan iterasi
        if ($tindakan->iterasi == 1) {
            // cek apakah dia masih punya quota

            $paketIterasi = PaketIterasi::where('tindakan_id', $tindakan->id)
                            ->where('pasien_id', $pendaftaran->pasien_id)
                            ->first();


            if ($paketIterasi) {
                // kalau sudah ada maka kurangi stock nya
                $request['discount'] = $tindakan['tarif_' . strtolower($jenisPendaftaran)];
                $paketIterasi->update(['quota' => ($paketIterasi->quota - 1)]);
            } else {
                $request['pasien_id'] = $pendaftaran->pasien_id;
                $request['quota'] = $tindakan->quota;
                //return $request->all();
                $paketIterasi = PaketIterasi::create($request->all());
                $request['paket_iterasi_id'] = $paketIterasi->id;
                // set sisa quota dikurang 1 karna sedang digunakan
                $request['quota'] = $tindakan->quota - 1;
                RiwayatPenggunaanTindakanIterasi::create($request->all());
                // set quota yang akan ditagihkan sesuai dengan data master
                $request['qty'] = $tindakan->quota;
            }
        }

        PendaftaranTindakan::create($request->all());
    }

    public function destroy($id)
    {
        $data = NomorAntrian::with('pendaftaran')->findOrFail($id);
        PendaftaranTindakan::where('pendaftaran_id', $data->pendaftaran_id)->where('poliklinik_id', $data->poliklinik_id)->delete();
        PendaftaranResep::where('pendaftaran_id', $data->pendaftaran_id)->where('poliklinik_id', $data->poliklinik_id)->delete();
        $data->delete();
    }

    public function show($id)
    {
        $nomorAntrian               = \App\Models\NomorAntrian::find($id);

        $data['rujukanInternal']    = RujukanInternal::with('dokter', 'poliklinik', 'tindakan')
                                    ->where('pendaftaran_id', $id);
                                    //->where('poliklinik_id',\Auth::user()->poliklinik_id);
        $data['nomorAntrian'] = NomorAntrian::with('poliklinik', 'dokter', 'tindakan')
                                ->where('poliklinik_id', '!=', $nomorAntrian->poliklinik_id)
                                ->where('pendaftaran_id', $nomorAntrian->pendaftaran_id);

        return view('pendaftaran.partials.rujukan_internal', $data);
    }
}
