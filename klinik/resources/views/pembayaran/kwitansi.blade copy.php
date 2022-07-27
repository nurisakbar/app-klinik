<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kwitansi Pembayaran</title>
    <style>
        .text-center {
            text-align: center;
        } 
        .mt-3 {
            margin-top: 30px;
        }
        .dotted {
            border-bottom: 1px dotted black
        }
    </style>
</head>
<body style="margin: -60px -40px;width:100%;transform: scale(0.9);">

    <div>
        <table>
            <tr>
                <td><img src="https://alumniphb.net/upload/loker//download_(3)1.png" alt=""></td>
                <td>
                    <h3>KLINIK DR. NURDIN WAHID</h3>
                    <p style="margin: -13px 0">Jl. HM. Ashari no.22 Cibinong-Bogor</p>
                    <p>Telp. 021 87916739</p>
                </td>
            </tr>
        </table>
    </div>
    <hr style="border: 1px dotted black">
    <h4 class="text-center" style="margin-top: -1px">BUKTI PEMBAYARAN</h4>

    <div style="margin-top: -20px">
        <table border="0">
            <tr>
                <td>RM / Nama Pasien</td>
                <td width="2px">:</td>
                <td>{{ $pendaftaran->pasien->nomor_rekam_medis }} / {{ $pendaftaran->pasien->inisial }} {{ $pendaftaran->pasien->nama }}</td>
                <td width="25px">&nbsp;</td>
                <td>Tanggal Kunjungan</td>
                <td width="2px">:</td>
                <td width="100">{{ tgl_indo(substr($pendaftaran->created_at, 0, 10)) }}</td>
            </tr>
            <tr>
                <td>Penjamin</td>
                <td>:</td>
                <td>{{ $pendaftaran->perusahaanAsuransi->nama_perusahaan }}</td>
            </tr>
        </table>
    </div>

    {{-- <hr style="width: 100%; border: 1px dotted black"> --}}

    <div style="margin: -10px;margin-left:-40px">
        <table style="transform:scale(.9);width: 100%;border-top: 1px dotted black;text-align:left">
            <thead class="dotted">
                <tr>
                    <th>NO</th>
                    <th width="380">KETERANGAN</th>
                    <th>QTY</th>
                    <th width="110">TARIF OBAT</th>
                    <th width="110">TARIF TINDAKAN</th>
                    {{-- <th>DISC</th> --}}
                    {{-- <th>TAGIHAN PENJAMIN</th>
                    <th>TAGIHAN PASIEN</th> --}}
                </tr>
            </thead>

            {{-- Deklarasi variabel untuk menampung data --}}
            @php
                $total = 0;
                $totalTindakan = 0;
                $totalObat = 0;
                $nomor=1;
            @endphp

            {{-- Data tagihan tindakan --}}
            {{-- <tr>
                <th></th>
                <th>TINDAKAN</th>
            </tr> --}}
            @foreach($tindakans as $tindakan)
            <tbody class="dotted" style="text-align:left">
                <tr>
                    <td>{{ $nomor }}</td>
                    <td>{{ $tindakan->tindakan->tindakan }} </td>
                    <td>{{ $tindakan->qty }}</td>
                    <td>-</td>
                    <td>{{ convert_rupiah($tindakan->fee) }}</td>
                    {{-- <td>-</td>
                    <td>{{ ($penjamin == 'UMUM') ? '-' : (($penjamin == 'BPJS') ? convert_rupiah($tindakan->fee) : convert_rupiah($tindakan->fee)) }}</td>
                    <td>{{ $penjamin == 'UMUM' ? convert_rupiah($tindakan->fee) : '-' }}</td> --}}
                </tr>
                @php
                    $totalTindakan += ($tindakan->fee*$tindakan->qty)-$tindakan->discount;
                    $nomor++;
                @endphp
            </tbody>
            @endforeach

            {{-- Data tagihan obat --}}
            {{-- <tr>
                <th></th>
                <th>OBAT</th>
            </tr> --}}
            @foreach($obats as $obat)
            <tbody class="dotted" style="text-align:left">
                <tr>
                    <td>{{ $nomor }}</td>
                    <td>{{ $obat->barang->nama_barang }}</td>
                    <td>{{ $obat->jumlah }}</td>
                    <td>{{ convert_rupiah($obat->harga) }}</td>
                    <td>-</td>
                </tr>
                @php
                    $totalObat += $obat->jumlah * $obat->harga;
                    $nomor++;
                @endphp
            </tbody>
            @endforeach

            {{-- Hitung total hasil dari semua harga tindakan dan obat --}}
            @php
             $total = $totalTindakan + $totalObat   
            @endphp
            
            <tbody class="dotted" style="text-align: left">
                <tr>
                    <td></td>
                    <td>BIAYA TAMBAHAN</td>
                    <td></td>
                    <td></td>
                    
            
                    <td colspan="2">RP. {{ rupiah($pendaftaran->biaya_tambahan) }}</td>
                </tr>

                <tr>
                    <td></td>
                    <td>TOTAL</td>
                    <td></td>
                    <td></td>
                    
            
                    <td width="60">{{ $penjamin != 'UMUM' ? convert_rupiah($total+ $pendaftaran->biaya_tambahan) : '-' }}</td>
                    <td width="60">{{ $penjamin == 'UMUM' ? convert_rupiah($total+ $pendaftaran->biaya_tambahan) : '-' }}</td>
                </tr>
            </tbody>
            <tbody class="dotted">
                <tr>
                    <td></td>
                    <td colspan="5"><i>TERBILANG #{{ strtoupper(terbilang($total + $pendaftaran->biaya_tambahan)) }}#</i></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div style="margin-top: 15px">
        <div style="float: right">
            <p style="margin-bottom:50px;padding-left:30px">Kasir</p>
            <p style="margin-bottom:-10px;margin-left:30px"><strong>{{ Auth::user()->name }}</strong></p>
            {{-- <p style="">Dokter Pemeriksa</p>
            <p style=""></p> --}}
        </div>
    </div>
    
</body>
</html>