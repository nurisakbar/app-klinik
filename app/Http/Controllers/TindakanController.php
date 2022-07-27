<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\Tindakan;
use App\Models\IndikatorPemeriksaanLab;
use App\Models\Poliklinik;
use App\Models\TindakanBHP;
use App\Models\Barang;
use App\Http\Requests\TindakanStoreRequest;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use App\Models\Satuan;
use App\Exports\TindakanExport;
use Maatwebsite\Excel\Facades\Excel;

class TindakanController extends Controller
{
    public $object_fee;


    public function __construct()
    {
        $this->object_fee   = config('datareferensi.object_fee');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Tindakan::with('poliklinik')->get())
            ->addColumn('action', function ($row) {
                $btn = "<a href='/tindakan/" . $row->id . "?tab=bhp' class='btn btn-danger btn-sm ' style='margin-right:10px'><i class='fa fa-eye'></i></a>";
                $btn .= \Form::open(['url' => 'tindakan/' . $row->id, 'method' => 'DELETE','style' => 'float:right;margin-right:5px']);
                $btn .= "<button type='submit' class='btn btn-danger btn-sm'><i class='fa fa-trash' aria-hidden='true'></i></button>";
                $btn .= \Form::close();
                $btn .= '<a class="btn btn-danger btn-sm" href="/tindakan/' . $row->id . '/edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                return $btn;
            })
            ->editColumn('kode', function ($row) {
                return $row->icd->code ?? '-';
            })
            ->editColumn('jenis', function ($row) {
                return config('datareferensi.jenis_tindakan')[$row->jenis];
            })
            ->addColumn('aktif', function ($row) {
                return $row->aktif == 1 ? 'Aktif' : 'Tidak Aktif';
            })
            ->rawColumns(['action','code'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('tindakan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['poliklinik'] = Poliklinik::pluck('nama', 'id');
        $data['jenis']      = ['umum','perusahaan','bpjs'];
        $data['object']     = $this->object_fee;
        return view('tindakan.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TindakanStoreRequest $request)
    {
        $request['pembagian_tarif'] = serialize($request->pembagian_tarif);
        if ($request->iterasi == 0) {
            $request['quota'] = 0;
        }
        Tindakan::create($request->all());
        return redirect(route('tindakan.index'))->with('message', 'Data Tindakan Berhasil Disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $data['tindakan']   = Tindakan::with('bhp.barang', 'indikator')->find($id);
        $tab = $request->tab == 'bhp' ? 'show' : 'indikator';
        $data['satuan'] = Satuan::pluck('satuan', 'id');
        return view('tindakan.' . $tab, $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['poliklinik'] = Poliklinik::pluck('nama', 'id');
        $data['tindakan']   = Tindakan::findOrFail($id);
        $data['object']     = $this->object_fee;
        $data['jenis']      = ['umum','perusahaan','bpjs'];
        return view('tindakan.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tindakan = Tindakan::findOrFail($id);
        $request['pembagian_tarif'] = serialize($request->pembagian_tarif);
        if ($request->iterasi == 0) {
            $request['quota'] = 0;
        }
        $tindakan->update($request->all());
        return redirect(route('tindakan.index'))->with('message', 'Data tindakan Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tindakan = Tindakan::findOrFail($id);
        TindakanBHP::where('tindakan_id', $tindakan->id)->delete();
        $tindakan->delete();
        return redirect(route('tindakan.index'))->with('message', 'Data tindakan Berhasil Dihapus');
    }


    public function import_tarif()
    {


        $tindakans = Tindakan::all();
        foreach ($tindakans as $row) {
                    $tindakan                   = Tindakan::find($row->id);
                    $umum                       = $tindakan->tarif_umum;
                    $perusahaan                 = $tindakan->tarif_perusahaan;
                    $bpjs                       = $tindakan->tarif_bpjs;

                    $klinik_umum    = (50 / 100) * (int) $umum;
                    $dokter_umum    = (50 / 100) * (int) $umum;
                    $perawat_umum   = (10 / 100) * (int) $klinik_umum;

                    $klinik_bpjs    = (50 / 100) * (int) $bpjs;
                    $dokter_bpjs    = (50 / 100) * (int) $bpjs;
                    $perawat_bpjs   = (10 / 100) * (int) $klinik_bpjs;

                    $klinik_perusahaan    = (50 / 100) * (int) $perusahaan;
                    $dokter_perusahaan    = (50 / 100) * (int) $perusahaan;
                    $perawat_perusahaan   = (10 / 100) * (int) $klinik_perusahaan;

                    $pembagian_tarif = [
                        'klinik-umum' => $klinik_umum - $perawat_umum,
                        'dokter-umum' => $dokter_umum,
                        'asisten-umum' => $perawat_umum,
                        'klinik-bpjs' => $klinik_bpjs - $perawat_bpjs,
                        'dokter-bpjs' => $dokter_bpjs,
                        'asisten-bpjs' => $perawat_bpjs,
                        'klinik-perusahaan' => $klinik_perusahaan - $perawat_perusahaan,
                        'dokter-perusahaan' => $dokter_perusahaan,
                        'asisten-perusahaan' => $perawat_perusahaan
                    ];



                    $tindakan->update(['pembagian_tarif' => serialize($pembagian_tarif)]);
        }
        return 'ok';
        $reader = ReaderEntityFactory::createXLSXReader();
        $filepath = public_path('uploads/tarif_tindakan.xlsx');
        $reader->open($filepath);
        foreach ($reader->getSheetIterator() as $sheet) {
            $data = [];
            foreach ($sheet->getRowIterator() as $row) {
                $cells                      = $row->getCells();

                $poliklinik                 = Poliklinik::where('nama', $cells[17])->first();
                \Log::info($cells[1]);
                //dd($cells);
                if ($poliklinik != null) {
                    $tindakan                   = $cells[1];
                    $umum                       = (string) $cells[2];
                    $perusahaan                 = (string) $cells[7];
                    $bpjs                       = (string) $cells[12];

                    $klinik_umum    = (50 / 100) * (int) $umum;
                    $dokter_umum    = (50 / 100) * (int) $umum;
                    $perawat_umum   = (10 / 100) * (int) $umum;

                    $klinik_bpjs    = (50 / 100) * (int) $bpjs;
                    $dokter_bpjs    = (50 / 100) * (int) $bpjs;
                    $perawat_bpjs   = (10 / 100) * (int) $bpjs;

                    $klinik_perusahaan    = (50 / 100) * (int) $perusahaan;
                    $dokter_perusahaan    = (50 / 100) * (int) $perusahaan;
                    $perawat_perusahaan   = (10 / 100) * (int) $perusahaan;

                    $pembagian_tarif = [
                        'klinik-umum' => $klinik_umum - $perawat_umum,
                        'dokter-umum' => $dokter_umum,
                        'asisten-umum' => $perawat_umum,
                        'klinik-bpjs' => $klinik_bpjs - $perawat_bpjs,
                        'dokter-bpjs' => $dokter_bpjs,
                        'asisten-bpjs' => $perawat_bpjs,
                        'klinik-perusahaan' => $klinik_perusahaan - $perawat_perusahaan,
                        'dokter-perusahaan' => $dokter_perusahaan,
                        'asisten-perusahaan' => $perawat_perusahaan
                    ];

                    \Log::info($pembagian_tarif);

                    $dataTindakan = [
                        'tindakan'              =>  $tindakan,
                        'kode'                  =>  null,
                        'poliklinik_id'         =>  $poliklinik->id,
                        'tarif_umum'            =>  $umum,
                        'tarif_perusahaan'      =>  $perusahaan,
                        'tarif_bpjs'            =>  $bpjs,
                        'iterasi'               =>  0,
                        'quota'                 =>  0,
                        'penunjang'             =>  0,
                        'pembagian_tarif'       =>  serialize($pembagian_tarif),
                        'jenis_tindakan_medis'  =>  0
                    ];
                    Tindakan::updateOrCreate(['tindakan' => $tindakan,'poliklinik_id' => $poliklinik->id], $dataTindakan);
                }
            }
        }
    }

    public function import(Request $request)
    {
        if ($request->kosongkan == 1) {
            Tindakan::truncate();
            TindakanBHP::truncate();
            IndikatorPemeriksaanLab::truncate();
        }

        $reader = ReaderEntityFactory::createXLSXReader();
        $file           = $request->file('file');
        $nama_file      = $file->getClientOriginalName();
        $file->move("uploads", $nama_file);
        $filePath = "uploads/" . $nama_file;
        $reader->open($filePath);
        foreach ($reader->getSheetIterator() as $sheet) {
            $data = [];
            foreach ($sheet->getRowIterator() as $row) {
                $cells                  = $row->getCells();
                $nomor                  = $cells[0];
                $kode_icd               = $cells[1];
                $nama_tindakan          = $cells[2];
                $jenis_tindakan         = $cells[3];
                $tarif_umum             = $cells[4];
                $tarif_perusahaan       = $cells[5];
                $tarif_bpjs             = $cells[6];
                $iterasi                = $cells[7];
                $quota                  = $cells[8];
                $fee_klinik_umum        = $cells[9];
                $fee_dokter_umum        = $cells[10];
                $fee_perawat_umum       = $cells[11];
                $fee_klinik_bpjs        = $cells[12];
                $fee_dokter_bpjs        = $cells[13];
                $fee_perawat_bpjs       = $cells[14];
                $fee_klinik_perusahaan  = $cells[15];
                $fee_dokter_perusahaan  = $cells[16];
                $fee_perawat_perusahaan = $cells[17];
                $nama_bhp               = $cells[18];
                $satuan                 = $cells[19];
                $jumlah                 = $cells[20];


                \Log::info($nomor);

                if ($nomor != 'Nomor') {
                    if ($nama_tindakan != '') {
                        $poli                   = \App\Models\Poliklinik::where('nama', $cells[21])->first();
                        $pembagian_tarif = [
                            'klinik-umum'       => $fee_klinik_umum,
                            'dokter-umum'       => $fee_dokter_umum,
                            'asisten-umum'      => $fee_perawat_umum,
                            'klinik-bpjs'       => $fee_klinik_bpjs,
                            'dokter-bpjs'       => $fee_dokter_bpjs,
                            'asisten-bpjs'      => $fee_perawat_bpjs,
                            'klinik-perusahaan' => $fee_klinik_perusahaan,
                            'dokter-perusahaan' => $fee_dokter_perusahaan,
                            'asisten-perusahaan' => $fee_perawat_perusahaan
                        ];

                        $tindakan = Tindakan::create([
                                'kode'              =>  null,
                                'tindakan'          =>  $nama_tindakan,
                                'poliklinik_id'     =>  $poli->id ?? 0,
                                'tarif_umum'        =>  $tarif_umum,
                                'tarif_bpjs'        =>  $tarif_bpjs,
                                'tarif_perusahaan'  =>  $tarif_perusahaan,
                                'pembagian_tarif'   => serialize($pembagian_tarif),
                                'iterasi'           =>  $iterasi == 'Ya' ? 1 : 0,
                                'penunjang'         =>  0,
                                'quota'             =>  $quota,
                                'jenis'             => $poli->nama == 'LAB' ? 'tindakan_laboratorium' : 'tindakan_medis',
                                'pelayanan'         => 'umum'
                        ]);
                    }


                    // insert barang
                    $pbf        = \App\Models\PedagangBesarFarmasi::firstOrCreate(['nama_pbf' => 'Default'], ['nama_pbf' => 'Default']);
                    $kategori   = \App\Models\Kategori::firstOrCreate(['nama_kategori' => 'Default'], ['nama_kategori' => 'Default']);
                    $satuan     = \App\Models\Satuan::firstOrCreate(['satuan' => $satuan], ['satuan' => $satuan]);
                    $barang = [
                        'kode'                      =>  null,
                        'nama_barang'               =>  $nama_bhp,
                        'keterangan'                =>  '',
                        'harga'                     =>  0,
                        'kategori_id'               =>  $kategori->id, // alkes
                        'satuan_terbesar_id'        =>  1,
                        'satuan_terkecil_id'        =>  $satuan->id,
                        'jenis_barang'              =>  'alkes',
                        'margin'                    =>  0,
                        'pelayanan'                 =>  'umum',
                        'jumlah_satuan_terbesar'    =>  $satuan->id,
                        'jumlah_satuan_terkecil'    =>  $satuan->id,
                        'pbf_id'                    =>  $pbf->id
                    ];

                    $brg = \App\Models\Barang::firstOrCreate(['nama_barang' => $nama_bhp], $barang);
                    TindakanBHP::create([
                        'barang_id'     => $brg->id,
                        'tindakan_id'   => $tindakan->id,
                        'satuan_id'     => $satuan->id,
                        'jumlah'        => $jumlah]);
                }
            }
        }
        unlink($filePath);
        return redirect('tindakan')->with('message', 'Import Tindakan sedang berlangsung');
    }


    public function excel(Request $request)
    {
        return Excel::download(new TindakanExport(), 'Data-master-tindakan' . date('Y-m-d-H-i-s') . '.xlsx');
    }
}
