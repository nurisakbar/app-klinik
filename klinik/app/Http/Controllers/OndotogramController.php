<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\PendaftaranTindakan;
use App\Models\Tindakan;
use Illuminate\Http\Request;
use PDF;
use App\Models\Satuan;
use App\Models\NomorAntrian;
use Auth;
use App\Models\PendaftaranFeeTindakan;
use App\Models\PendaftaranResep;
use App\Models\TindakanBHP;
use App\Models\Barang;
use App\User;
use App\Models\Poliklinik;

class OndotogramController extends Controller
{
    public function index($pendaftaranId)
    {
        $data['poliklinik1']            = Poliklinik::pluck('nama', 'id');
        $data['dokter1']                = User::where('role', 'dokter')->pluck('name', 'id');
        $data['nomorAntrian']           = NomorAntrian::with('pendaftaran')->find($pendaftaranId);

        if ($data['nomorAntrian']->pendaftaran->tanda_tanda_vital == null) {
            return redirect('pendaftaran/' . $pendaftaranId . '/input_tanda_vital');
        }
        if ($data['nomorAntrian']->pendaftaran->pemeriksaan_klinis != '') {
            return view('pendaftaran.pemeriksaan_klinis_form', $data);
        }
        $data['pendaftaran_gigi']   = PendaftaranTindakan::with(['tbm', 'tindakan'])->where('pendaftaran_id', $data['nomorAntrian']->pendaftaran_id)->get();
        $data['total']              = count($data['pendaftaran_gigi']);
        $data['satuan']             = Satuan::pluck('satuan', 'id');
        $data['riwayatKunjungan'] =     \DB::select("select na.id,
                p.kode,
                pa.nomor_rekam_medis,
                pa.nama as nama_pasien,
                cast(p.created_at as Date) as tanggal_kunjungan,
                po.nama as poliklinik,
                pas.nama_perusahaan as perusahaan_penjamin
                from nomor_antrian as na
                join pendaftaran as p on p.id=na.pendaftaran_id
                join pasien as pa on pa.id=p.pasien_id and pa.id='" . $data['nomorAntrian']->pendaftaran->pasien_id . "'
                join poliklinik as po on po.id=na.poliklinik_id
                join perusahaan_asuransi as pas on pas.id=p.perusahaan_asuransi_id");
        return view('ondotogram.index', $data);
    }

    public function store(Request $request)
    {
        $pendaftaran    = Pendaftaran::with('perusahaanAsuransi')->findOrFail($request->pendaftaran_id);
        $tindakan       = Tindakan::findOrFail($request->tindakan_id);
        $request['qty'] = 1;
        $nomorAntrian   = NomorAntrian::where('pendaftaran_id', $request->pendaftaran_id)
                    ->where('poliklinik_id', $request->poliklinik_id)
                    ->first();





        $jenisPendaftaran   =  strtolower($nomorAntrian->perusahaanAsuransi->nama_perusahaan);
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


        if ($nomorAntrian->perusahaanAsuransi->nama_perusahaan == 'UMUM') {
            $fee = $tindakan->tarif_umum;
        } else if ($nomorAntrian->perusahaanAsuransi->nama_perusahaan == 'BPJS') {
            $fee = $tindakan->tarif_bpjs;
        } else {
            $fee = $tindakan->tarif_perusahaan;
        }


        $request['poliklinik_id'] = Auth::user()->poliklinik_id;
        $request['fee'] = $fee;
        $stored = PendaftaranTindakan::create($request->all());
        $result = PendaftaranTindakan::with(['tbm', 'tindakan'])->where('id', $stored->id)->first();

        $logTindakan = serialize($tindakan);
        // Pemberian Fee Untuk Dokter
        $pendaftaranFeeTindakan = PendaftaranFeeTindakan::create([
            'tindakan_id'       =>  $request->tindakan_id,
            'pendaftaran_id'    =>  $request->pendaftaran_id,
            'poliklinik_id'     =>  Auth::user()->poliklinik_id,
            'jumlah_fee'        =>  $fee_tindakan['dokter-' . $jenisPendaftaran],
            'user_id'           =>  Auth::user()->id,
            'log_tindakan'      =>  $logTindakan,
            'pelaksana'         => 'Dokter'
        ]);

        // Pemberian fee Untuk Klinik
        $pendaftaranFeeTindakan = PendaftaranFeeTindakan::create([
            'tindakan_id'       =>  $request->tindakan_id,
            'pendaftaran_id'    =>  $request->pendaftaran_id,
            'poliklinik_id'     =>  Auth::user()->poliklinik_id,
            'jumlah_fee'        =>  $fee_tindakan['klinik-' . $jenisPendaftaran],
            'log_tindakan'      =>  $logTindakan,
            'pelaksana'         => 'Klinik'
        ]);

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
                    'poliklinik_id'         =>  \Auth::user()->poliklinik_id,
                    'tindakan_id'           => $request->tindakan_id,
                    'harga'                 =>  $barang->harga_jual,
                ]);
            }
        }
        $response = [
            "success" => true,
            "message" => "Data berhasil ditambahkan",
            "data" => $result
        ];
        return response($response, 201);
    }

    public function print($pendaftaranId)
    {
        $nomorAntrian           = NomorAntrian::with('pendaftaran.pasien')->find($pendaftaranId);
        $data['pendaftaran']    = PendaftaranTindakan::with(['tbm', 'pendaftaran'])
                                ->where('pendaftaran_id', $nomorAntrian->pendaftaran_id)
                                ->where('poliklinik_id', Auth::user()->poliklinik_id)
                                ->get();
        $data['nomorAntrian'] = $nomorAntrian;
        if ($nomorAntrian->perusahaanAsuransi->nama_perusahaan == 'BPJS') {
            $nomorAntrian->update(['status_pembayaran' => 1,'metode_pembayaran' => 'BPJS','status_pelayanan' => 'selesai']);
        } else {
            $nomorAntrian->update(['status_pelayanan' => 'selesai']);
        }


        $pdf = PDF::loadView('ondotogram.cetak-hasil', $data);
        return $pdf->stream();
    }

    public function destroy($id)
    {
        PendaftaranTindakan::where('id', $id)->delete();
        $response = [
            "success" => true,
            "message" => "Data berhasil dihapus",
        ];
        return response($response, 200);
    }
}
