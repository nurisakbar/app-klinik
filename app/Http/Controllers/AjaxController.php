<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DokterPoliklinik;
use App\Models\JadwalPraktek;
use App\Models\PurchaseOrderDetail;
use App\Models\PurchaseOrder;
use App\Models\IndikatorPemeriksaanLab;
use App\Models\HasilPemeriksaanLab;
use App\Models\PermintaanBarangInternalDetail;
use App\User;
use App\Models\Pasien;
use App\Models\Barang;
use App\Models\PendaftaranResep;
use App\Models\Pegawai;
use App\Models\Pendaftaran;
use App\Models\Poliklinik;
use DB;
use App\Models\NomorAntrian;
use App\Models\PendaftaranTindakan;
use App\Models\TindakanBHP;

class AjaxController extends Controller
{
    public function dropdownDokterBerdasarkanPoliklinik(Request $request)
    {
        $user = JadwalPraktek::with('user')->where('poliklinik_id', $request->poliklinik)
            ->where('hari', date('l'))
            ->get();

        $dokter = [];
        foreach ($user as $row) {
            if (isset($row->user)) {
                $dokter[$row->user_id] = $row->user->name;
            }
        }
        $dokter[0] = 'Dokter Pegganti';
        return \Form::select('dokter_id', $dokter, null, ['class' => 'form-control dokter', 'onChange' => 'dokterPegganti()']);
    }

    // pencarian nama desa dengan element select2
    public function select2Desa(Request $request)
    {
        $data = \DB::table('view_wilayah_administratif_indonesia')
            ->select('village_id', \DB::raw('CONCAT(village_name, ", ", district_name,", ", regency_name, ", ",province_name) AS village_name'))
            ->where('village_name', 'like', "%" . $request->q . "%")
            ->limit(20)
            ->get();
        return response()->json($data);
    }

    public function select2Pasien(Request $request)
    {
        $data = \DB::table('pasien')
            ->select('id', 'nama', 'nomor_rekam_medis', 'nama_ibu', 'tanggal_lahir')
            ->where('nama', 'like', "%" . $request->q . "%")
            ->orWhere('nama_ibu', 'like', "%" . $request->q . "%")
            ->orWhere('nomor_rekam_medis', 'like', "%" . $request->q . "%")
            ->limit(20)
            ->get();
        return response()->json($data);
    }


    public function simpanAnamnesa(Request $request)
    {
        $nomorAntrian = NomorAntrian::find($request->nomor_antrian_id);

        // hitung durasi pelayanan
        $waktu_daftar           = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $nomorAntrian->created_at);
        $waktu_input_anamnesa   = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', now());
        $durasi_pelayanan       = $waktu_daftar->diffInMinutes($waktu_input_anamnesa);
        $nomorAntrian->update(['anamnesa' => $request->anamnesa,'durasi_pelayanan' => $durasi_pelayanan]);
        if ($nomorAntrian) {
            return response()->json($nomorAntrian);
        }
    }


    public function select2Barang(Request $request)
    {
        if ($request->has('poliklinik_id')) {
            $poliklinik = Poliklinik::find($request->poliklinik_id);
            $data = \DB::table('barang')
            ->join('distribusi_stock', 'distribusi_stock.barang_id', 'barang.id')
            ->select('barang.id', DB::raw('CONCAT(barang.nama_barang, " ( ", distribusi_stock.jumlah_stock,")") AS nama_barang'), 'barang.harga')
            ->where('distribusi_stock.unit_stock_id', $poliklinik->unit_stock_id)
            ->where('distribusi_stock.jumlah_stock', '>', 0)
            ->where('barang.nama_barang', 'like', "%" . $request->q . "%");



            if (\session('lock_bpjs') != null) {
                if (\session('lock_bpjs') == 'yes') {
                    $data = $data->where('pelayanan', 'bpjs');
                }
            }
        } else {
            $data = Barang::where('nama_barang', 'like', "%" . $request->q . "%");
        }

        if ($request->has('pelayanan')) {
            if (strtoupper($request->pelayanan) == 'BPJS') {
                $data->where('barang.pelayanan', 'bpjs');
            }
        }

        $data->orWhere('barang.keterangan', 'like', "%" . $request->q . "%")->groupBy('barang.id');

        return response()->json($data->limit(20)->get());
    }

    public function select2Indikator(Request $request)
    {
        $data = \DB::table('indikator')
            ->select('id', 'nama_indikator')
            ->where('nama_indikator', 'like', "%" . $request->q . "%")
            ->limit(20)
            ->get();
        return response()->json($data);
    }

    public function select2Pendaftaran(Request $request)
    {
        $data = \DB::table('pendaftaran')
            ->select('id', 'kode')
            ->where('kode', 'like', "%" . $request->q . "%")
            ->limit(20)
            ->get();
        return response()->json($data);
    }

    public function select2Dokter(Request $request)
    {
        $data = \DB::table('users')
            ->select('id', 'name')
            ->where('role', 'dokter')
            ->where('name', 'like', "%" . $request->q . "%")
            ->limit(20)
            ->get();
        return response()->json($data);
    }

    public function select2Poliklinik(Request $request)
    {
        $data = \DB::table('poliklinik')
            ->select('id', 'nama')
            ->where('nama', 'like', "%" . $request->q . "%")
            ->limit(20)
            ->get();
        return response()->json($data);
    }

    public function select2TindakanLaboratorium(Request $request)
    {
        $data = \DB::table('jenis_pemeriksaan_laboratorium')
            ->select('id', 'nama_jenis')
            ->where('nama_jenis', 'like', "%" . $request->q . "%")
            ->limit(20)
            ->get();
        return response()->json($data);
    }

    public function select2Tindakan(Request $request)
    {
        if (in_array($request->poliklinik_id, [2,3])) {
            $poliklinik_id = 2;
        } else {
            $poliklinik_id = $request->poliklinik_id;
        }





        $data = \DB::table('tindakan')
            ->select('id', 'tindakan', 'kode')
            ->where('tindakan', 'like', "%" . $request->q . "%");

        if ($request->has('poliklinik_id')) {
            $data->where('poliklinik_id', $poliklinik_id);
        }

        if (!$request->has('poliklinik_id')) {
            if (session('filter_tindakan_rujukan_by_poliklinik_id') != null) {
                $data->where('poliklinik_id', session('filter_tindakan_rujukan_by_poliklinik_id'));
            }
        }
        return response()->json($data->limit(20)->get());
    }

    public function select2ICD(Request $request)
    {
        $data = \DB::table('tbm_icd')
            ->select('id', 'indonesia', 'kode')
            ->where('indonesia', 'like', "%" . $request->q . "%")
            ->orWhere('kode', 'like', "%" . $request->q . "%")
            ->limit(20)
            ->get();
        return response()->json($data);
    }

    public function select2ICDNine(Request $request)
    {
        $data = \DB::table('tbm_icd_nine')
            ->select('id', 'code', 'desc_short')
            ->where('desc_short', 'like', "%" . $request->q . "%")
            ->orWhere('code', 'like', "%" . $request->q . "%")
            ->limit(20)
            ->get();
        return response()->json($data);
    }

    public function pasien(Request $request)
    {
        return Pasien::where('id', $request->pasien_id)->first();
    }

    public function user(Request $request)
    {
        $pegawai = Pegawai::findOrFail($request->pegawai_id);
        return User::where('id', $pegawai->user_id)->first();
    }

    public function purchaseOrderEditTable(Request $request)
    {
        if ($request->name !== null && $request->value !== null) {
            PurchaseOrderDetail::find($request->pk)->update([$request->name => $request->value]);

            if ($request->name === 'harga') {
                $request['value'] = 'Rp. ' . number_format($request->value, 0, ',', '.');
            }
            $request['status'] = true;
            $request['message'] = 'Data berhasil diubah';
            return $request->all();
        }

        $request['status'] = false;
        $request['message'] = 'Tidak ada data yg terubah';
        return $request->all();
    }

    public function indikatorEditable(Request $request)
    {
        if ($request->name !== null && $request->value !== null) {
            IndikatorPemeriksaanLab::find($request->pk)->update([$request->name => $request->value]);
            $request['status'] = true;
            $request['message'] = 'Data berhasil diubah';
            return $request->all();
        }

        $request['status'] = false;
        $request['message'] = 'Tidak ada data yg terubah';
        return $request->all();
    }

    public function hasilPemeriksaanLabEditable(Request $request)
    {
        if ($request->name !== null && $request->value !== null) {
            HasilPemeriksaanLab::find($request->pk)->update([$request->name => $request->value]);
            $request['status'] = true;
            $request['message'] = 'Data berhasil diubah';
            return $request->all();
        }

        $request['status'] = false;
        $request['message'] = 'Tidak ada data yg terubah';
        return $request->all();
    }

    public function permintaanBarangDetailEditable(Request $request)
    {
        $permintaanBarangDetail = PermintaanBarangInternalDetail::find($request->pk);
        $request['oldValue'] = $permintaanBarangDetail->jumlah_diterima;
        $permintaanBarangDetail->update([$request->name => $request->value]);

        return $request->all();
    }

    public function select2User(Request $request)
    {
        $data = \DB::table('users')
            ->select('id', 'name')
            ->where('name', 'like', "%" . $request->q . "%")
            ->limit(20)
            ->get();
        return response()->json($data);
    }

    public function approvalItemPurchaseOrder(Request $request)
    {
        $item = PurchaseOrderDetail::findOrFail($request->id);
        $item->update($request->only('catatan', 'approval'));
        $purchase_order = \DB::select("select sum((harga-(diskon/100*harga))*qty) as total from purchase_order_detail where approval=1
        and purchase_order_id=" . $item->purchase_order_id);

        return response()->json(
            [
                'message'   =>  'update sukses',
                'total'     =>  $purchase_order[0]->total
            ]
        );
    }

    public function dropdownDokter(Request $request)
    {
        $dokter = User::where('role', 'dokter')->pluck('name', 'id');
        return \Form::select('dokter_pengganti', $dokter, null, ['class' => 'form-control']);
    }

    // pencarian nama desa dengan element select2
    public function select2Perusahaan(Request $request)
    {
        $data = \DB::table('perusahaan_asuransi')
            ->select('id', 'nama_perusahaan')
            ->where('nama_perusahaan', 'like', "%" . $request->q . "%")
            ->limit(20)
            ->get();
        return response()->json($data);
    }

    // pencarian nama TBM dengan element select2
    public function select2TBM(Request $request)
    {
        $data = \DB::table('tbm_icd')
            ->select('id', 'indonesia')
            ->where('indonesia', 'like', "%" . $request->q . "%")
            ->where('dtd', 'K00')
            ->limit(20)
            ->get();
        return response()->json($data);
    }

    // pencarian nama jenis pekerjaan dengan element select2
    public function select2Pekerjaan(Request $request)
    {
        $data = config('datareferensi.jenis_pekerjaan');

        return response()->json($data);
    }

    // pencarian nama suku bangsa dengan element select2
    public function select2SukuBangsa(Request $request)
    {
        $data = config('datareferensi.suku_bangsa');

        return response()->json($data);
    }

    public function nomorAntrialCall(Request $request)
    {
        $poliklinik = \App\Models\Poliklinik::find($request->poliklinik_id);

        $total_antrian = \App\Models\NomorAntrian::whereRaw("left(created_at,10)='" . date('Y-m-d') . "'")
        ->where('dokter_id', session('user_id'))
        ->count();

        $sudah_dipanggil = $antrian = \App\Models\NomorAntrian::whereRaw("left(created_at,10)='" . date('Y-m-d') . "'")
        ->where('dokter_id', session('user_id'))
        ->where('sudah_dipanggil', 1)
        ->count();

        $belum_dipanggil = \App\Models\NomorAntrian::whereRaw("left(created_at,10)='" . date('Y-m-d') . "'")
        ->where('dokter_id', session('user_id'))
        ->where('sudah_dipanggil', 0)
        ->count();

        $belum_dipanggil = \App\Models\NomorAntrian::whereRaw("left(created_at,10)='" . date('Y-m-d') . "'")
        ->where('dokter_id', session('user_id'))
        ->where('sudah_dipanggil', 0)
        ->count();

        $antrian_sekarang = \App\Models\NomorAntrian::whereRaw("left(created_at,10)='" . date('Y-m-d') . "'")
        ->where('dokter_id', session('user_id'))
        ->where('sudah_dipanggil', 0)
        ->first();


        if ($request->type == 2) {
            $antrian_sekarang->update(['sudah_dipanggil' => 1]);

            $antrian_sekarang = \App\Models\NomorAntrian::whereRaw("left(created_at,10)='" . date('Y-m-d') . "'")
            ->where('dokter_id', session('user_id'))
            ->where('sudah_dipanggil', 0)
            ->first();
        }


        $hasil = [
            'jumlah_total_antrian' => $total_antrian,
            'poliklinik_tujuan' => $poliklinik->nama == 'LAB' ? 'Laboratorium' : $poliklinik->nama,
            'antrian_sekarang' => $antrian_sekarang->nomor_antrian,
            'sisa_antrian' => $total_antrian - $antrian_sekarang->nomor_antrian
        ];
        return $hasil;
    }

    public function lock_bpjs(Request $request)
    {

        \session(['lock_bpjs' => $request->lock_bpjs]);
        return session('lock_bpjs');
    }

    public function checkPoliKebidanan(Request $request)
    {
        $pendaftaran = \App\Models\Pendaftaran::find($request->pendaftaran_id);
        $value = $pendaftaran->check_list_poli_kebidanan == 0 ? 1 : 0;
        $pendaftaran->update(['check_list_poli_kebidanan' => $value]);
        return $value;
    }


    public function pendaftaranBhpDelete(Request $request)
    {

        $itemBhp = PendaftaranResep::where('barang_id', $request->barang_id)
        ->where('pendaftaran_id', $request->pendaftaran_id)
        ->where('tindakan_id', $request->tindakan_id)
        ->where('jenis', 'bhp')
        ->first();
        return $itemBhp->delete();
    }

    public function pendaftaranBhpInsert(Request $request)
    {
        $barang                 = Barang::with('satuanTerkecil')->where('id', $request->barang_id)->first();
        $pendaftaranTindakan    = \App\Models\PendaftaranTindakan::where('id', $request->pendaftaran_tindakan_id)->first();
        return PendaftaranResep::create([
            'barang_id'             =>  $request->barang_id,
            'pendaftaran_id'        =>  $pendaftaranTindakan->pendaftaran_id,
            'jumlah'                =>  $request->jumlah,
            'satuan_terkecil_id'    =>  $barang->satuan_terkecil_id,
            'aturan_pakai'          =>  '',
            'jenis'                 =>  'bhp',
            'harga'                 =>  $barang->harga_jual,
            'tindakan_id'           =>  $pendaftaranTindakan->tindakan_id,
            'is_bpjs'               =>  0,
            'poliklinik_id'         =>  $pendaftaranTindakan->poliklinik_id

        ]);
    }


    public function updateDiskonTindakan(Request $request)
    {
    // update diskon pada kasir
        $pendaftaranTindakan = PendaftaranTindakan::find($request->id);
        $pendaftaranTindakan->update(['discount' => $request->discount]);
        return $pendaftaranTindakan;
    }


    public function ubahJumlahBHP(Request $request)
    {
        return TindakanBHP::where('id', $request->id)->update(['jumlah' => $request->jumlah]);
    }

    public function checkTindakanRujukanTemp(Request $request)
    {
        return \DB::table('pendaftaran_tindakan_temp')
        ->where('pasien_id', $request->pasien_id)
        ->where('perusahaan_asuransi_id', $request->perusahaan_asuransi_id)
        ->count();
    }

    public function filter_tindakan_rujukan(Request $request)
    {
        session(['filter_tindakan_rujukan_by_poliklinik_id' => $request->poliklinik_id]);
    }
}
