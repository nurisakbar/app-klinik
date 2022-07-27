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
                <td>{{ $nomorAntrian->pendaftaran->pasien->nomor_rekam_medis }} / {{ $nomorAntrian->pendaftaran->pasien->inisial }} {{ $nomorAntrian->pendaftaran->pasien->nama }}</td>
                <td width="25px">&nbsp;</td>
                <td>Tanggal Kunjungan</td>
                <td width="2px">:</td>
                <td width="100">{{ tgl_indo(substr($nomorAntrian->created_at, 0, 10)) }}</td>
            </tr>
            <tr>
                <td>Penjamin</td>
                <td>:</td>
                <td>{{ $nomorAntrian->perusahaanAsuransi->nama_perusahaan }}</td>
            </tr>
        </table>
    </div>

    {{-- <hr style="width: 100%; border: 1px dotted black"> --}}

    <div style="margin: -10px;margin-left:-40px">
        <table style="transform:scale(.9);width: 100%;border-top: 1px dotted black">
            <thead class="dotted">
                <tr>
                    <th width="30" style="text-align:left">NO</th>
                    <th width="250" style="text-align:left">ITEM PEMBAYARAN</th>
                    <th width="65" style="text-align:left">TARIF</th>
                    <th width="65" style="text-align:left">QTY</th>
                    <th width="65" style="text-align:left">DISKON</th>
                    <th width="65" style="text-align:left">SUBTOTAL</th>
                    <th width="70" style="text-align:left">KETERANGAN</th>
                </tr>
            </thead>
            @php
                $total = 0;
                $totalTindakan = 0;
                $totalObat = 0;
                $nomor=1;
            @endphp
            @foreach($tindakans as $tindakan)
            <tbody class="dotted">
                <?php
                  if($nomorAntrian->perusahaanAsuransi->nama_perusahaan=='BPJS' && $tindakan->tindakan->pelayanan=='bpjs'){
                    $feeTindakan = 0;
                    $keterangan = "BPJS";
                  }else{
                    $feeTindakan = $tindakan->fee;
                    $keterangan  = "-";
                  }
                  ?>

                <tr>
                    <td>{{ $nomor }}</td>
                    <td>{{ $tindakan->tindakan->tindakan }} </td>
                    <td>{{ rupiah($feeTindakan) }}</td>
                    <td>{{ $tindakan->qty }}</td>
                    <td>{{ rupiah($tindakan->discount) }}</td>
                    <td>{{ rupiah(($feeTindakan-$tindakan->discount)*$tindakan->qty) }}</td>
                    <td>Tindakan</td>
                </tr>
                @php
                    $total += ($feeTindakan-$tindakan->discount)*$tindakan->qty;
                    $nomor++;
                @endphp
            </tbody>
            @endforeach


            @if($nomorAntrian->poliklinik_id!=7)
                @foreach($bhps as $bhp)
                <?php
                        if($nomorAntrian->perusahaanAsuransi->nama_perusahaan=='BPJS' && $bhp->barang->pelayanan=='bpjs'){
                        $hargaBHP = 0;
                        $keterangan = "BPJS";
                    }else{
                        $hargaBHP = $bhp->harga;
                        $keterangan  = "-";
                    }
                        ?>
                <tbody class="dotted">
                    <tr>
                        <td>{{ $nomor }}</td>
                        <td>{{ $bhp->barang->nama_barang }}</td>
                        <td>{{ rupiah($hargaBHP) }}</td>
                        <td>{{ $bhp->jumlah }}</td>
                        <td>0</td>
                        <td>{{ rupiah($hargaBHP*$bhp->jumlah) }}</td>
                        <td>BHP</td>
                    </tr>
                    @php
                        $total += $hargaBHP*$bhp->jumlah;
                        $nomor++;
                    @endphp
                </tbody>
                @endforeach
        @endif


            @foreach($nonRaciks as $non)
            <?php
            if($nomorAntrian->perusahaanAsuransi->nama_perusahaan=='BPJS' && $non->barang->pelayanan=='bpjs'){
            $hargaObatNonRacik = 0;
            $keterangan = "BPJS";
          }else{
            $hargaObatNonRacik = $non->harga;
            $keterangan  = "-";
          }
            ?>
            <tbody class="dotted">
                <tr>
                    <td>{{ $nomor }}</td>
                    <td>{{ $non->barang->nama_barang }}</td>
                    <td>{{ rupiah($hargaObatNonRacik) }}</td>
                    <td>{{ $non->jumlah }}</td>
                    <td>0</td>
                    <td>{{ rupiah($hargaObatNonRacik*$non->jumlah) }}</td>
                    <td>Obat Non Racik</td>
                </tr>
                @php
                    $total += $non->jumlah * $hargaObatNonRacik;
                    $nomor++;
                @endphp
            </tbody>
            @endforeach



            @foreach($obatRacik as $racik)
                @foreach($racik->detail as $itm)
                    <?php
                if($nomorAntrian->perusahaanAsuransi->nama_perusahaan=='BPJS' && $itm->barang->pelayanan=='bpjs'){
                    $hargaObatRacik = 0;
                    $keterangan = "BPJS";
                }else{
                    $hargaObatRacik = $itm->harga;
                    $keterangan  = "-";
                }
                ?>
                <tbody class="dotted">
                    <tr>
                        <td>{{ $nomor }}</td>
                        <td>{{ $itm->barang->nama_barang }}</td>
                        <td>{{ rupiah($hargaObatRacik) }}</td>
                        <td>{{ $itm->jumlah }}</td>
                        <td>0</td>
                        <td>{{ rupiah($hargaObatRacik*$itm->jumlah) }}</td>
                        <td>Obat Racik</td>
                    </tr>
                    @php
                        $total += $itm->jumlah * $hargaObatRacik;
                        $nomor++;
                    @endphp
                </tbody>
                @endforeach
            @endforeach

            <tbody class="dotted">
                <tr>
                    <td></td>
                    <td>BIAYA TAMBAHAN</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td colspan="2" style="font-weight: bold">{{ rupiah($nomorAntrian->biaya_tambahan) }}</td>
                </tr>
            </tbody>
            <tbody class="dotted">
                <tr>
                    <td></td>
                    <td>TOTAL</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    
            
                    <td width="60" style="font-weight: bold">{{ rupiah($total+$nomorAntrian->biaya_tambahan) }}</td>
                </tr>
            </tbody>
            <tbody class="dotted">
                <tr>
                    <td></td>
                    <td colspan="5"><i>TERBILANG #{{ strtoupper(terbilang($total + $nomorAntrian->biaya_tambahan)) }}#</i></td>
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