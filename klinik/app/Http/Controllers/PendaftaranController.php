<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use App\Models\PendaftaranDiagnosa;
use App\Models\Tindakan;
use App\Models\Obat;
use App\Models\Poliklinik;
use App\Models\Pasien;
use App\Models\Satuan;
use App\Models\PendaftaranTindakanTemp;
use App\Models\PendaftaranObatRacik;
use App\Models\PendaftaranObatRacikDetail;
use App\Models\JenisPemeriksaanLab;
use App\Models\HasilPemeriksaanLab;
use App\Models\IndikatorPemeriksaanLab;
use App\Models\RiwayatPenyakit;
use App\Models\Barang;
use App\Models\PendaftaranResep;
use App\Models\RujukanInternal;
use DataTables;
use PDF;
use Auth;
use DB;
use Carbon\Carbon;
use App\Http\Requests\PendaftaranInputTandaVitalRequest;
use App\Http\Requests\PendaftaranStoreRequest;
use App\Imports\PendaftaranImport;
use App\Models\PerusahaanAsuransi;
use App\Models\Pegawai;
use App\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\PendaftaranTindakan;
use App\Models\NomorAntrian;
use App\Models\PendaftaranFeeTindakan;
use App\Models\TindakanBHP;
use App\Models\ViewPendaftaran;

class PendaftaranController extends Controller
{
    protected $penjamin;
    protected $hubungan_pasien;
    protected $jenis_pendaftaran;
    protected $jenis_rujukan;
    protected $status_pelayanan;

    public function __construct()
    {
        $this->hubungan_pasien   = config('datareferensi.hubungan_pasien');
        $this->jenis_pendaftaran = config('datareferensi.jenis_pendaftaran');
        $this->jenis_rujukan     = config('datareferensi.jenis_rujukan');
        $this->inisial           = config('datareferensi.inisial');
        $this->status_pelayanan  = config('datareferensi.status_pelayanan');
    }

    public function index(Request $request)
    {
        // return auth()->user()->poliklinik_id;
        $data['tanggal_awal']   = $request->tanggal_awal ?? date('Y-m-d');
        $data['tanggal_akhir']  = $request->tanggal_akhir ?? date('Y-m-d');
        $data['poliklinik_id']  = $request->poliklinik_id;
        $data['perusahaan_asuransi_id']  = $request->perusahaan_asuransi_id;

        $awal                   = date('Y-m-d', strtotime($data['tanggal_awal']));
        $akhir                  = date('Y-m-d', strtotime($data['tanggal_akhir']));
        $nomorAntrian = ViewPendaftaran::whereBetween('tanggal', [$awal, $akhir]);


        // ------------------ FILTER BERDASARKAN POLIKLINIK -----------------------------
        if ($request->poliklinik_id != null) {
            $nomorAntrian->where('poliklinik_id', $request->poliklinik_id);
        }

        if ($request->perusahaan_asuransi_id != null) {
            $nomorAntrian->where('perusahaan_asuransi_id', $request->perusahaan_asuransi_id);
        }

        // ------------------ FILTER PADA ROLE POLIKLINIK -----------------------------
        if (auth()->user()->role == 'poliklinik') {
            if (auth()->user()->poliklinik_id == 1) {
                $nomorAntrian->whereIn('status_pelayanan', ['pendaftaran','selesai','selesai_pemeriksaan_medis']);
                $nomorAntrian->where('nama_dokter', session('user_name'));
            } else {
                if (auth()->user()->poliklinik_id == 7) {
                    // jika lab
                    $nomorAntrian->where('status_pembayaran', 1);
                } else {
                    $nomorAntrian->where('nama_dokter', session('user_name'));
                }

                $nomorAntrian->whereIn('status_pelayanan', ['selesai_pemeriksaan_medis','selesai_pelayanan','selesai']);
                $nomorAntrian->where('poliklinik_id', Auth::user()->poliklinik_id);
            }
        }
        // ------------------ FILTER PADA ROLE KASIR -----------------------------
        if (auth()->user()->role == 'kasir') {
            $nomorAntrian->whereIn('status_pelayanan', ['selesai_pemeriksaan_medis','selesai_pelayanan','selesai_pembayaran','selesai']);
        }

        // ------------------ FILTER PADA ROLE APOTEKER -----------------------------
        if (auth()->user()->role == 'apoteker') {
            $nomorAntrian->where('status_pembayaran', 1);
            $nomorAntrian->where('poliklinik_id', '!=', 7);
        }

        if ($request->ajax()) {
            $status_pelayanan = $this->status_pelayanan;
            return DataTables::of($nomorAntrian)
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group">';
                    $btn .= '<button type="button" class="btn btn-danger">Pilih Tindakan</button>
                               <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
                               <span class="caret"></span>
                               <span class="sr-only">Toggle Dropdown</span>
                             </button>';
                    $btn .= '<ul class="dropdown-menu" role="menu">';

                    // --------------------- ACTION YANG AKAN MUNCUL DI BAGIAN PENDAFTARAN -----------------------
                    if (auth()->user()->role == 'bagian_pendaftaran') {
                        if (in_array($row->status_pelayanan, ['pendaftaran','selesai_pemeriksaan_medis'])) {
                            $btn .= \Form::open(['url' => 'pendaftaran/' . $row->id, 'method' => 'DELETE', 'style' => 'margin-left:15px']);
                            $btn .= "<li><button type='submit' style='border: 0;background:#fff'><i class='fa fa-times'></i> <span style='margin-left:10px'>Batal</span></button></li>";
                            $btn .= \Form::close();
                            $btn .= '<li><a href="/pendaftaran/' . $row->id . '/cetak"><i class="fa fa-print"></i> Cetak Antrian</a></li>';
                            $btn .= '<li><a href="/pendaftaran/' . $row->id . '/edit"><i class="fa fa-edit"></i> Edit</a></li>';
                        }
                    }

                    // --------------------- ACTION YANG AKAN MUNCUL DI BAGIAN REKAMEDIS -----------------------
                    if (auth()->user()->role == 'rekamedis') {
                        $btn .= '<li><a href="/pendaftaran/' . $row->id . '/pemeriksaan"><i class="fa fa-edit"></i> Lihat Tindakan</a></li>';
                    }

                    // --------------------- ACTION YANG AKAN MUNCUL DI BAGIAN ADMIN MEDIS -----------------------
                    if (auth()->user()->role == 'admin_medis') {
                        if ($row->status_pelayanan != 'batal') {
                            if ($row->status_pelayanan != 'selesai_pemeriksaan_medis') {
                                $btn .= '<li><a href="/pendaftaran/' . $row->id . '/input_tanda_vital"><i class="fa fa-print"></i> Input Tanda Vital</a></li>';
                            } else {
                                $btn .= \Form::open(['url' => 'pendaftaran/' . $row->id, 'method' => 'DELETE', 'style' => 'margin-left:15px']);
                                $btn .= "<li><button type='submit' style='border: 0;background:#fff'><i class='fa fa-times'></i> <span style='margin-left:10px'>Batal</span></button></li>";
                                $btn .= \Form::close();
                                $btn .= '<li><a href="/pendaftaran/' . $row->id . '/edit"><i class="fa fa-edit"></i> Edit</a></li>';
                            }
                        }
                    }

                    // --------------------- ACTION YANG AKAN MUNCUL DI BAGIAN POLIKLINIK -----------------------
                    if (auth()->user()->role == 'poliklinik') {
                        if ($row->poliklinik_id == 1) { // poli gigi
                            $btn .= '<li><a href="/ondotogram/' . $row->id . '"><i class="fa fa-plus-square"></i> Pemeriksaan Gigi</a></li>';
                        } elseif ($row->poliklinik_id == 7) { // lab
                                $btn .= '<li><a class="btn btn-danger btn-sm" href="/pendaftaran/' . $row->id . '/input-indikator"><i class="fa fa-edit"></i> Input Indikator</a></li>';
                        } else {
                            if ($row->status_pelayanan == 'selesai_pelayanan') {
                                $btn .= '<li><a href="/pendaftaran/' . $row->id . '/pemeriksaan"><i class="fa fa-edit"></i> Edit tindakan</a></li>';
                            } else {
                                $btn .= '<li><a href="/pendaftaran/' . $row->id . '/pemeriksaan"><i class="fa fa-edit"></i> Input tindakan</a></li>';
                            }
                        }
                    }

                    // --------------------- ACTION YANG AKAN MUNCUL DI BAGIAN ADMIN MEDIS -----------------------
                    if (auth()->user()->role == 'kasir') {
                        if ($row->status_pembayaran == 0) {
                            $btn = '<a class="btn btn-danger btn-sm" style="margin-right:5px" href="/pembayaran/' . $row->id . '"><i class="fa fa-money"></i></a></div>';
                        } else {
                            $btn = '<a class="btn btn-danger btn-sm btn-block" target="new" href="/pembayaran/' . $row->id . '/kwitansi"><i class="fa fa-print"></i></a></div>';
                        }
                    }

                    // --------------------- ACTION YANG AKAN MUNCUL DI BAGIAN ADMINISTRATOR -----------------------
                    if (auth()->user()->role == 'administrator') {
                        if ($row->status_pelayanan == 'selesai') {
                            $btn .= \Form::open(['url' => 'pendaftaran/' . $row->id, 'method' => 'DELETE', 'style' => 'margin-left:15px']);
                            $btn .= "<li><button type='submit' style='border: 0;background:#fff'><i class='fa fa-times'></i> <span style='margin-left:10px'>Batal</span></button></li>";
                            $btn .= \Form::close();
                        }
                    }

                    // --------------------- ACTION YANG AKAN MUNCUL DI BAGIAN APOTEKER -----------------------
                    if (auth()->user()->role == 'apoteker') {
                        $btn .= '<li><a href="/pendaftaran/apotek/lihat-item/' . $row->id . '"><i class="fa fa-plus-square"></i> Cetak Label</a></li>';
                    }
                    $btn .= '</ul>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->addColumn('status_pelayanan', function ($row) use ($status_pelayanan) {
                    //return $status_pelayanan[$row->status_pelayanan];
                    return $row->status_pelayanan;
                })
                ->addColumn('nomor_antrian_waktu', function ($row) use ($status_pelayanan) {
                    return $row->tanggal . ' - ' . $row->nomor_antrian;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        $data['poliklinik'] = Poliklinik::pluck('nama', 'id');
        $data['perusahaanAsuransi'] = PerusahaanAsuransi::pluck('nama_perusahaan', 'id');
        return view('pendaftaran.index', $data);
    }

    public function create($pasien_id = null)
    {
        $data['perusahaan_asuransi'] = PerusahaanAsuransi::pluck('nama_perusahaan', 'id');
        $data['jenis_rujukan']     = $this->jenis_rujukan;
        $data['hubungan_pasien']   = $this->hubungan_pasien;
        $data['jenis_pendaftaran'] = $this->jenis_pendaftaran;

        $data['poliklinik']         = Poliklinik::pluck('nama', 'id');
        $data['daftar_pasien']      = Pasien::pluck('nama', 'id');
        $data['pasien_id']          = $pasien_id;
        $data['tidakanLab']         = Tindakan::where('jenis', 'tindakan_laboratorium')->pluck('tindakan', 'id');
        return view('pendaftaran.pasien-terdaftar', $data);
    }

    public function input_indikator($id)
    {
        $data['nomorAntrian']                   = NomorAntrian::with('pendaftaran', 'poliklinik')->find($id);
        $data['pendaftaranTindakan']            = PendaftaranTindakan::with('tindakan.indikator')
                                                    ->where('poliklinik_id', $data['nomorAntrian']->poliklinik_id)
                                                    ->where('pendaftaran_id', $data['nomorAntrian']->pendaftaran_id)
                                                    ->get();
        $data['hasilPemeriksaan']               = HasilPemeriksaanLab::where('pendaftaran_id', $id)->get();
        return view('pendaftaran.indikator', $data);
    }

    public function simpanHasilPemeriksaanLab($pendaftaranId, Request $request)
    {
        //return $request->all();

        $nomorAntrian = \App\Models\NomorAntrian::find($request->nomor_antrian_id);
        \DB::table('pendaftaran_hasil_pemeriksaan_lab')->where('pendaftaran_id', $nomorAntrian->pendaftaran_id)->delete();
        $indexIndikator = 0;
        foreach ($request->id_tindakan as $id_tindakan) {
            $tindakan = \App\Models\Tindakan::with('indikator')->find($id_tindakan);
            $pendaftaranTindakan = \App\Models\PendaftaranTindakan::where('pendaftaran_id', $nomorAntrian->pendaftaran_id)
                                    ->where('tindakan_id', $id_tindakan)
                                    ->where('poliklinik_id', $nomorAntrian->poliklinik_id)
                                    ->first();
            foreach ($tindakan->indikator as $indikator) {
                $params[] = [
                    'indikator_pemeriksaan_lab_id' => $request->indikator_id[$indexIndikator],
                    'hasil' => $request->hasil[$indexIndikator],
                    'pendaftaran_tindakan_id' => $pendaftaranTindakan->id,
                    'catatan' => $request->catatan[$indexIndikator],
                    'pendaftaran_id' => $nomorAntrian->pendaftaran_id,
                    'tindakan_id' => $tindakan->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
                if ($indexIndikator <= count($request->indikator_id) - 2) {
                    $indexIndikator++;
                }
            }
        }


        \DB::table('pendaftaran_hasil_pemeriksaan_lab')->insert($params);
        RujukanInternal::where('pendaftaran_id', $pendaftaranId)->update(['status' => 'Selesai']);

        $notifikasi = \DB::table('notifikasi')
                    ->where('pasien_id', $nomorAntrian->pendaftaran->pasien_id)
                    ->where('poliklinik_id', $nomorAntrian->poliklinik_id)
                    ->update(['link' => 'pendaftaran/' . $request->nomor_antrian_id . '/input-indikator/print','display' => 1]);
        return redirect('pendaftaran/' . $request->nomor_antrian_id . '/input-indikator')->with('message', 'Data Berhasil Disimpan');
    }

    public function printHasilPemeriksaan($id, Request $request)
    {
        $data['nomorAntrian'] = NomorAntrian::with('pendaftaran.pasien', 'dokter')->where('id', $id)
        ->with('poliklinik', 'dokter')
        ->first();


        $data['tindakanLab'] = \App\Models\PendaftaranTindakan::with('tindakan')->where('poliklinik_id', $data['nomorAntrian']->poliklinik_id)
        ->where('pendaftaran_id', $data['nomorAntrian']->pendaftaran_id)->get();
        $pdf = PDF::loadView('pendaftaran.pdf_hasil_pemeriksaan_lab', $data)->setPaper('letter', 'potrait');
        return $pdf->stream();
    }

    public function input_tanda_vital($id)
    {
        $data['nomorAntrian'] = NomorAntrian::find($id);
        $data['pendaftaran'] = Pendaftaran::with('pasien')->find($data['nomorAntrian']->pendaftaran_id);
        return view('pendaftaran.input_tanda_vital', $data);
    }

    public function input_tanda_vital_store($id, PendaftaranInputTandaVitalRequest $request)
    {
        $nomorAntrian = NomorAntrian::find($id);
        $pendaftaran = Pendaftaran::find($nomorAntrian->pendaftaran_id);
        $input          = $request->except(['_token', '_method']);
        $data           = [
            'tanda_tanda_vital'     => serialize($request->only(
                'berat_badan',
                'tekanan_darah',
                'jenis_kasus',
                'suhu_tubuh',
                'tinggi_badan',
                'nadi',
                'rr',
                'kesadaran',
                'saturasi_o2',
                'fungsi_penciuman',
                'status_alergi_value',
                'lingkar_perut',
                'djj',
                'pernafasan',
                'asuhan_keperawatan',
                'tfu',
                'imt'
            )),
            'pemeriksaan_klinis'    =>  serialize($request->pemeriksaan_klinis),
            'status_alergi'         => $request->status_alergi_value
        ];
        $nomorAntrian->update(['status_pelayanan' => 'selesai_pemeriksaan_medis']);
        $pendaftaran->update($data);

        if ($nomorAntrian->poliklinik_id == 1) {
            return redirect('ondotogram/' . $nomorAntrian->id);
        }
        return redirect('pendaftaran/')->with('message', 'Tanda Tanda Vital Berhasil Disimpan');
    }

    public function detailPasien(Request $request)
    {
        $pendaftaran = Pendaftaran::find($id);
        $data = Pasien::where('id', $request->id)->first();
        return $data;
    }

    public function store(PendaftaranStoreRequest $request)
    {
        $request['dokter_id']   = $request->dokter_id == 0 ? $request->dokter_pengganti : $request->dokter_id;
        $request['kode']        = generateKodePendaftaran();
        $data = Pendaftaran::create($request->all());
        // create nomor antrian
        $nomor = NomorAntrian::where('poliklinik_id', $request->poliklinik_id)
                            ->whereDate('created_at', date('Y-m-d'))
                            ->max('nomor_antrian');
        $nomorAntrianData = [
            'pendaftaran_id'            =>  $data->id,
            'poliklinik_id'             =>  $request->poliklinik_id,
            'dokter_id'                 =>  $request['dokter_id'],
            'status_pelayanan'          =>  'pendaftaran',
            'perusahaan_asuransi_id'    =>  $request->perusahaan_asuransi_id,
            'nomor_antrian'             =>  ($nomor + 1)
        ];

        $nomorAntrian = NomorAntrian::create($nomorAntrianData);

        // jika poli gigi, set pemeriksaan_klinis true agar tidak perlu input lagi
        if ($request->poliklinik_id == 1) {
            Pendaftaran::where('id', $nomorAntrian->pendaftaran_id)->update(['pemeriksaan_klinis' => 'N;']);
        }

        if ($request->tindakan_id != null) {
            $request['pendaftaran_id'] = $data->id;
            $this->lengkapiTindakanTemp($request);
        }
        return redirect('/pendaftaran/' . $nomorAntrian->id . '/cetak');
    }

    public function lengkapiTindakanTemp($request)
    {
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

        \Log::debug($request);

        $pendaftaran        = Pendaftaran::with('perusahaanAsuransi')->find($request->pendaftaran_id);
        $tindakan           = Tindakan::find($request->tindakan_id);

        \Log::info($tindakan);


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

    public function edit($id)
    {
        //$data['pendaftaran']         = Pendaftaran::with('pasien')->findOrFail($id);
        $data['perusahaan_asuransi']    = PerusahaanAsuransi::pluck('nama_perusahaan', 'id');
        $data['poliklinik']             = Poliklinik::pluck('nama', 'id');
        $data['nomorAntrian']           = NomorAntrian::with('pendaftaran.pasien')->findOrFail($id);
        $data['dokter']                 = User::where('role', 'dokter')->pluck('name', 'id');
        return view('pendaftaran.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $nomor      = NomorAntrian::where('poliklinik_id', $request->poliklinik_id)->whereDate('created_at', date('Y-m-d'))->max('nomor_antrian');
        $antrian    = NomorAntrian::where('id', $id)->first();
        $antrian->update(['dokter_id' => $request->dokter_id,'perusahaan_asuransi_id' => $request->perusahaan_asuransi_id, 'nomor_antrian' => ($nomor + 1),'poliklinik_id' => $request->poliklinik_id]);
        return redirect('/pendaftaran/' . $id . '/cetak');
    }

    public function cetak($id)
    {
        $data['nomorAntrian'] = NomorAntrian::with('pendaftaran', 'poliklinik', 'dokter')->where('id', $id)->orderBy('id', 'DESC')->first();
        return view('pendaftaran.nomor-antrian', $data);
    }

    public function print($id)
    {
        $data['nomorAntrian'] = NomorAntrian::with('pendaftaran', 'poliklinik', 'dokter')->where('id', $id)->orderBy('id', 'DESC')->first();
        $pdf = PDF::loadView('pendaftaran.cetak', $data);
        return $pdf->stream();
    }

    public function destroy($id)
    {
        NomorAntrian::where('id', $id)->update(['status_pelayanan' => 'batal']);
        return redirect('/pendaftaran');
    }

    public function hapus($id)
    {
        // hapus nomor antrian
        // hapus pendaftaran
        // hapus tindakan
        // hapus
    }

    public function pemeriksaanRiwayatPenyakit(Request $request, $id)
    {
        $request['pendaftaran_id'] = $id;
        $pendaftaran = Pendaftaran::findOrFail($id);
        $request['pasien_id'] = $pendaftaran->pasien_id;
        RiwayatPenyakit::create($request->all());
        return view('pendaftaran.ajax-table-riwayat-penyakit');
    }

    public function pemeriksaanRiwayatPenyakitHapus($id)
    {
        $data = RiwayatPenyakit::findOrFail($id);
        $data->delete();

        return view('pendaftaran.ajax-table-riwayat-penyakit');
    }

    public function resumeRiwayatPenyakit(Request $request)
    {
        if ($request->ajax()) {
            $pendaftaran = Pendaftaran::with('pasien.riwayatPenyakit')->findOrFail($request->id);
            return DataTables::of($pendaftaran->pasien->riwayatPenyakit)
                ->editColumn('kode', function ($row) {
                    return $row->tbmIcd->kode;
                })
                ->editColumn('tbm_icd', function ($row) {
                    return $row->tbmIcd->indonesia;
                })
                ->addColumn('action', function ($row) {
                    $btn = "<div class='btn btn-danger btn-sm' data-id = '" . $row->id . "' onClick='removeRiwayatPenyakit(this)'>Hapus</div>";
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function selesai($id)
    {
        $nomorAntrian = NomorAntrian::with('pendaftaran')->find($id);
        $nomorAntrian->update(['status_pelayanan' => 'selesai_pelayanan']);
        if ($nomorAntrian->perusahaanAsuransi->nama_perusahaan == 'BPJS') {
            // chek apakah semua obat dan bph pakai bpjs ?
            $checkResepBpjs = \DB::table('pendaftaran_resep')
                                ->where('pendaftaran_id', $nomorAntrian->pendaftaran_id)
                                ->where('poliklinik_id', $nomorAntrian->poliklinik_id)
                                ->where('is_bpjs', 0)
                                ->count();
            // jika tidak ada obat dan bhp yang non bpjs maka set autoclose bpjs
            if ($checkResepBpjs == 0) {
                $nomorAntrian->update(['status_pembayaran' => 1,'metode_pembayaran' => 'BPJS']);
            }
        }
        return redirect('/pendaftaran')->with('message', 'Selesai Melakukan Pelayanan');
    }

    public function riwayatRawatJalan(Request $request)
    {
        $riwayatRawatJalan = Pendaftaran::with(['poliklinik', 'dokter', 'perusahaanAsuransi'])->where('id', $request->id)->get();

        if ($request->ajax()) {
            return DataTables::of($riwayatRawatJalan)
                ->addColumn('created_at', function ($row) {
                    return substr($row->created_at, 0, 10);
                })
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function import_excel(Request $request)
    {
        // menangkap file excel
        $file = $request->file('import_file');

        // membuat nama file unik
        $nama_file = $file->getClientOriginalName();

        // upload ke folder file_siswa di dalam folder public
        $file->move('file-excel', $nama_file);

        // import data
        try {
            Excel::import(new PendaftaranImport(), public_path('/file-excel/' . $nama_file));
            return redirect('/pendaftaran')->with('message', 'Data calon pasien berhasil diimport!');
        } catch (\Throwable $th) {
            return redirect(route('pendaftaran.index'))->with('message', 'File excel tidak valid!');
        }
    }

    public function pemeriksaan($id)
    {
        $data['nomorAntrian']            = NomorAntrian::with('pendaftaran.pasien')->find($id);
        if ($data['nomorAntrian']->pendaftaran->pemeriksaan_klinis == false && $data['nomorAntrian']->poliklinik_id != 5) {
            return view('pendaftaran.pemeriksaan_klinis_form', $data);
        }

        $data['dokter1']                = User::where('role', 'dokter')->pluck('name', 'id');
        $data['dokter2']                = User::where('role', '!=', 'dokter')->pluck('name', 'id');
        $data['satuan']                 = Satuan::pluck('satuan', 'id');
        $data['poliklinik1']            = Poliklinik::pluck('nama', 'id');
        $data['pendaftaranResepRacik']  = PendaftaranObatRacik::where('pendaftaran_id', $id);
        $data['jenisPemeriksaanLaboratorium'] = Tindakan::pluck('tindakan', 'id');
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
                                        join perusahaan_asuransi as pas on pas.id=p.perusahaan_asuransi_id
                                        order by na.created_at desc");
        $data['barang'] = Barang::pluck('nama_barang', 'id');
        return view('pendaftaran.pemeriksaan', $data);
    }

    public function simpanPemeriksaanKlinis(Request $request)
    {

        $nomorAntrian =  NomorAntrian::find($request->pendaftaran_id);
        $pendaftaran = Pendaftaran::find($nomorAntrian->pendaftaran_id);
        $pendaftaran->update(['pemeriksaan_klinis' => serialize($request->pemeriksaan_klinis)]);

        if ($nomorAntrian->poliklinik_id == 1) {
            return redirect('ondotogram/' . $request->pendaftaran_id);
        }
        return redirect('pendaftaran/' . $request->pendaftaran_id . '/pemeriksaan');
    }

    public function cetakRekamedis($id)
    {
        $data['nomorAntrian']       = NomorAntrian::where('id', $id)->first();
        $data['pendaftaran']        = Pendaftaran::with('pasien', 'jenisLayanan')->find($data['nomorAntrian']->pendaftaran_id);
        $data['riwayatKunjungan']   = Pendaftaran::with('poliklinik', 'dokter', 'perusahaanAsuransi')
        ->where('pasien_id', $data['pendaftaran']->pasien->id)
        ->get();
        $data['pendaftaranTindakan']    = PendaftaranTindakan::where('pendaftaran_id', $data['nomorAntrian']->pendaftaran_id)->get();
        $data['pendaftaranDiagnosa']    = PendaftaranDiagnosa::where('pendaftaran_id', $data['nomorAntrian']->pendaftaran_id)->get();
        $data['pendaftaranResep']       = PendaftaranResep::where('jenis', '!=', 'bhp')->where('pendaftaran_id', $data['nomorAntrian']->pendaftaran_id)->get();
        $data['riwayatPenyakit']        = RiwayatPenyakit::where('pasien_id', $data['pendaftaran']->pasien_id)->get();
        $pdf = PDF::loadView('pendaftaran.cetak_rekamedis', $data);
        return $pdf->stream();
    }


    public function logRiwayatIterasi($id)
    {
        $data['riwayat'] = \App\Models\RiwayatPenggunaanTindakanIterasi::all();
        return view('pasien.log_riwayat_iterasi', $data);
    }

    public function logRiwayatKunjungan($id)
    {
        $data['pendaftaran']    = NomorAntrian::with('pendaftaran')->findOrFail($id);
        $data['tindakan']       = PendaftaranTindakan::with('tindakan')
                                ->where('pendaftaran_id', $data['pendaftaran']->pendaftaran_id)
                                ->get();
        $data['diagnosa']       = PendaftaranDiagnosa::with('icd')
                                ->where('pendaftaran_id', $data['pendaftaran']->pendaftaran_id)
                                ->get();

        $data['obatNonRacik']   = PendaftaranResep::with('barang')
                                ->where('pendaftaran_id', $data['pendaftaran']->pendaftaran_id)
                                ->where('jenis', '!=', 'bhp')
                                ->get();
        $data['pendaftaranResepRacik'] = PendaftaranObatRacik::with('detail.barang')
                                ->where('pendaftaran_id', $data['pendaftaran']->pendaftaran_id);

        return view('pasien.riwayat_kunjungan_detail', $data);
    }

    public function apotek_lihat_item($id)
    {
        $data['nomorAntrian'] = NomorAntrian::with('pendaftaran')->find($id);
        $data['pendaftaranResep']   = PendaftaranResep::with(['barang.satuanTerkecil'])
                                        ->where('jenis', '!=', 'bhp')
                                        ->where('pendaftaran_id', $data['nomorAntrian']->pendaftaran_id);
        $data['pendaftaranResepRacik'] = PendaftaranObatRacik::with('detail.barang')
                                        ->where('pendaftaran_id', $data['nomorAntrian']->pendaftaran_id);
        return view('apotek.lihat_item', $data);
    }
}
