<?php

use App\Models\Gaji;
use App\Models\Pegawai;
use App\Models\GajiDetail;
use App\Models\KehadiranPegawai;
use App\Models\PegawaiTunjanganGaji;
use App\Models\PendaftaranTindakan;

function generateUniqNumber($table, $field, $prefix)
{
    $latestValue = \DB::table($table)->max($field);
    if ($latestValue == null) {
        return $prefix . '0001';
    } else {
        $noUrut = (int) substr($latestValue, 3, 3) + 1;
        return $prefix . sprintf("%03s", $noUrut);
    }
}


function generateKodePendaftaran()
{
    $latestValue = \DB::table('pendaftaran')->max('kode');
    if ($latestValue == null) {
        return 'PD-' . date('Ymd') . '0001';
    } else {
        $noUrut = (int) substr($latestValue, 11, 5) + 1;
        return 'PD-' . date('Ymd') . sprintf("%04s", $noUrut);
    }
}

function generateKodeRekamMedis()
{
    $latestValue = \DB::table('pasien')
    ->whereRaw("left(nomor_rekam_medis,3)='NMC'")
    ->whereRaw("CHAR_LENGTH(nomor_rekam_medis)=11")
    ->max('nomor_rekam_medis');
    if ($latestValue == null) {
        return 'NMC00000001';
    } else {
        $noUrut = (int) substr($latestValue, 4, 8) + 1;
        return 'NMC' . sprintf("%08s", $noUrut);
    }
}

function generateKodePurchaseOrder()
{
    $latestValue = \DB::table('purchase_order')->max('kode');
    if ($latestValue == null) {
        return 'PO-00000001';
    } else {
        $noUrut = (int) substr($latestValue, 4, 8) + 1;
        return 'PO-' . sprintf("%08s", $noUrut);
    }
}

function hitung_umur($date)
{
    if ($date == null) {
        return '-';
    }

    if ($date == '0000-00-00') {
        return '-';
    }

    $sekarang      = Carbon\Carbon::now();
    $tanggal_lahir = Carbon\Carbon::parse($date);
    $umur = $tanggal_lahir->diffInYears($sekarang);

    return $umur;
}

function convert_rupiah($value)
{
    return "Rp. " . number_format($value) . "";
}

function rupiah($value)
{
    return number_format($value, 0, '.', '.');
}

function penyebut($nilai)
{
    $nilai = abs($nilai);
    $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($nilai < 12) {
        $temp = " " . $huruf[$nilai];
    } elseif ($nilai < 20) {
        $temp = penyebut($nilai - 10) . " belas";
    } elseif ($nilai < 100) {
        $temp = penyebut($nilai / 10) . " puluh" . penyebut($nilai % 10);
    } elseif ($nilai < 200) {
        $temp = " seratus" . penyebut($nilai - 100);
    } elseif ($nilai < 1000) {
        $temp = penyebut($nilai / 100) . " ratus" . penyebut($nilai % 100);
    } elseif ($nilai < 2000) {
        $temp = " seribu" . penyebut($nilai - 1000);
    } elseif ($nilai < 1000000) {
        $temp = penyebut($nilai / 1000) . " ribu" . penyebut($nilai % 1000);
    } elseif ($nilai < 1000000000) {
        $temp = penyebut($nilai / 1000000) . " juta" . penyebut($nilai % 1000000);
    } elseif ($nilai < 1000000000000) {
        $temp = penyebut($nilai / 1000000000) . " milyar" . penyebut(fmod($nilai, 1000000000));
    } elseif ($nilai < 1000000000000000) {
        $temp = penyebut($nilai / 1000000000000) . " trilyun" . penyebut(fmod($nilai, 1000000000000));
    }
    return $temp;
}

function terbilang($nilai)
{
    if ($nilai < 0) {
        $hasil = "minus " . trim(penyebut($nilai));
    } else {
        $hasil = trim(penyebut($nilai));
    }
    return ucwords($hasil);
}

function tgl_indo($tanggal)
{
    if (in_array($tanggal, ['0000-00-00',null])) {
        return '-';
    }

    $bulan = array(
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $pecahkan = explode('-', $tanggal);
    return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}

function hitung_kehadiran($pegawai_id, $tanggal_mulai, $tanggal_akhir, $status_kehadiran)
{
    $kehadiran_pegawai = KehadiranPegawai::with('pegawai')
        ->where('pegawai_id', $pegawai_id)
        ->whereIn('status', $status_kehadiran)
        ->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir])
        ->get()
        ->count();

    return $kehadiran_pegawai;
}

function hitung_gaji($id)
{
    $gaji           = Gaji::findOrFail($id);

    // Hitung end dan start, bulan ini plus tanggal 25.
    $periodeEnd = $gaji->periode . '-25';
    $periodeStart = date('Y-m-d', strtotime('-29 day', strtotime($periodeEnd)));

    $pegawai        = Pegawai::with('kelompok_pegawai')->findOrFail($gaji->pegawai_id);
    $gaji_detail    = GajiDetail::with('komponen_gaji')->whereBetween('created_at', [$periodeStart, $periodeEnd])->where('pegawai_id', $pegawai->id)->get();

    // Handle tunjangan gaji
    $status_kehadiran = [];
    $kehadiran = KehadiranPegawai::where('pegawai_id', $pegawai->id);

    foreach ($kehadiran->get() as $k) {
        array_push($status_kehadiran, ['status' => $k->status]);
    }

    $total_kehadiran = hitung_kehadiran($pegawai->id, $periodeStart, $periodeEnd, $status_kehadiran);

    $jml_penambah = 0;

    $penambah = [];
    // Gaji pokok
    $penambah[0]['nama_komponen'] = 'gaji pokok';
    $penambah[0]['jumlah'] = $pegawai->gaji_pokok;
    $penambah[0]['jenis'] = 'penambah';

    // Tunjangan kehadiran
    $penambah[1]['nama_komponen'] = 'Tunjangan Kehadiran';
    $penambah[1]['jumlah'] = $total_kehadiran * $pegawai->tunjangan_kehadiran;
    $penambah[1]['jenis'] = 'penambah';
    $i = 2;

    foreach ($gaji_detail as $detail) {
        if ($detail->komponen_gaji->jenis == 'penambah') {
            $penambah[$i]['nama_komponen'] = $detail->komponen_gaji->nama_komponen;
            $penambah[$i]['jumlah'] = $detail->jumlah;
            $penambah[$i]['jenis'] = 'penambah';
            $i++;
        }
    }

    foreach ($penambah as $p) {
        if ($p['jenis'] == 'penambah') {
            $jml_penambah += $p['jumlah'];
        }
    }

    $jml_pengurang = 0;

    foreach ($gaji_detail as $detail) {
        if ($detail->komponen_gaji->jenis == 'pengurang') {
            $jml_pengurang += $detail->jumlah;
        }
    }
    $total = $jml_penambah - $jml_pengurang;
    return $total;
}

// Function for register or get device
function device($method, $device = null)
{
    $client = new GuzzleHttp\Client();

    if ($method == "GET") {
        if ($device == null) {
            $url = env('API_WA') . '/devices/';
        } else {
            $url = env('API_WA') . '/devices/' . $device;
        }

        $res = $client->request($method, $url, [
            'headers' => [
                'Content-type' => 'application/json',
                'Authorization' => 'Bearer hAW=E/lldj_G^9F3oOZPvMkCkw}{_jNqLNM/MxjsR^KgFoeQ-nuris'
            ],
        ]);
    }

    if ($method == "POST") {
        $res = $client->request($method, env('API_WA') . '/devices', [
            'headers' => [
                'Content-type' => 'application/json',
                'Authorization' => 'Bearer hAW=E/lldj_G^9F3oOZPvMkCkw}{_jNqLNM/MxjsR^KgFoeQ-nuris'
            ],
            'body' => json_encode([
                'device_id' => $device
            ])
        ]);
    }

    if ($method == "DELETE") {
        $url = env('API_WA') . '/devices/' . $device;
        $res = $client->request($method, $url, [
            'headers' => [
                'Content-type' => 'application/json',
                'Authorization' => 'Bearer hAW=E/lldj_G^9F3oOZPvMkCkw}{_jNqLNM/MxjsR^KgFoeQ-nuris'
            ],
        ]);
    }

    $response = json_decode($res->getBody()->getContents());
    return $response;
}

// Function for get QR Code
function getQRCode($device)
{
    $query = http_build_query(['device_id' => $device]);
    $client = new GuzzleHttp\Client();
    $url = env('API_WA') . '/qr?' . $query;

    $res = $client->request('GET', $url, [
        'headers' => [
            'Content-type' => 'application/json',
            'Authorization' => 'Bearer hAW=E/lldj_G^9F3oOZPvMkCkw}{_jNqLNM/MxjsR^KgFoeQ-nuris'
        ],
    ]);
    $response = json_decode($res->getBody()->getContents());
    return $response;
}

// Function for send message WA and get message by id
function message($method, $message = null, $phone_number = null, $message_type = null, $device = null)
{
    $client = new GuzzleHttp\Client();
    if ($method == "GET") {
        $query = http_build_query([
            'status' => 'success'
        ]);

        if ($message == null) {
            $url = env('API_WA') . '/messages?' . $query;
        } else {
            $url = env('API_WA') . '/messages/' . $message;
        }

        $res = $client->request($method, $url, [
            'headers' => [
                'Content-type' => 'application/json',
                'Authorization' => 'Bearer hAW=E/lldj_G^9F3oOZPvMkCkw}{_jNqLNM/MxjsR^KgFoeQ-nuris'
            ],
        ]);
    }

    if ($method == "POST") {
        $url = env('API_WA') . '/messages';
        $res = $client->request($method, $url, [
            'headers' => [
                'Content-type' => 'application/json',
                'Authorization' => 'Bearer hAW=E/lldj_G^9F3oOZPvMkCkw}{_jNqLNM/MxjsR^KgFoeQ-nuris'
            ],
            'body' => json_encode([
                'message' => $message,
                'phone_number' => $phone_number,
                'message_type' => $message_type,
                'device_id' => $device
            ])
        ]);
    }

    $response = json_decode($res->getBody()->getContents());
    return $response;
}

function checkDataGigi($kodeGigi, $pendaftaranId)
{
    $pendaftaran = PendaftaranTindakan::where('kode_gigi', $kodeGigi)->where('pendaftaran_id', $pendaftaranId)->first();

    if ($pendaftaran != null) {
        return true;
    } else {
        return false;
    }
}


function rekapKehadiranSetahun($pegawai_id, $tahun, $status_kehadiran)
{
    return \DB::table('kehadiran_pegawai')
    ->where('pegawai_id', $pegawai_id)
    ->where('status', $status_kehadiran)->whereRaw('left(tanggal,4)=' . $tahun . '')->count();
}
