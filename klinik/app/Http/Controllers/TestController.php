<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use App\Models\Barang;
use App\Models\TindakanBHP;
use App\Models\Pendaftaran;
use App\Models\PendaftaranDiagnosa;
use App\Models\PendaftaranFeeTindakan;
use App\Models\PendaftaranObatRacik;
use App\Models\PendaftaranTindakan;
use App\Models\NomorAntrian;
use App\Models\CatatanBarangKeluar;
use App\Models\HasilPemeriksaanLab;
use App\Models\PendaftaranResep;
use App\Models\RujukanInternal;
use App\Models\Surat;

class TestController extends Controller
{
    function test(Request $request)
    {
        Pendaftaran::truncate();
        Surat::truncate();
        PendaftaranDiagnosa::truncate();
        PendaftaranFeeTindakan::truncate();
        PendaftaranObatRacik::truncate();
        HasilPemeriksaanLab::truncate();
        PendaftaranTindakan::truncate();
        PendaftaranResep::truncate();
        NomorAntrian::truncate();
        RujukanInternal::truncate();
        CatatanBarangKeluar::truncate();
    }
}
