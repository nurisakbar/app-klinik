<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="widtd=device-widtd, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Keterangan Sakit</title>
</head>

<body>

    @include('surat.kop_surat')
    <h4 style="text-align: center">SURAT RUJUKAN</h4>

    <div class="mt-3">
        <table>
            <tr>
                <td>Kepada YTH Dokter</td>
                <td>:</td>
                <td>
                    {{ $surat->spesialis??''}}
                </td>
            </tr>
            <tr>
                <td>Di</td>
                <td>:</td>
                <td>
                    {{ $surat->faskes_tujuan}}
                </td>
            </tr>
            <tr>
                <td width="130">Nama</td>
                <td>:</td>
                <td align="left"> {{ $surat->pendaftaran->pasien->nama }}</td>
            </tr>
            <tr>
                <td width="120">Tanggal Lahir, Usia</td>
                <td>:</td>
                <td align="left">{{ $surat->pendaftaran->pasien->tanggal_lahir }}, {{hitung_umur($surat->pendaftaran->pasien->tanggal_lahir)}} Tahun</td>
            </tr>
            <tr>
                <td width="120">Jenis Kelamin</td>
                <td>:</td>
                <td align="left"> {{ $surat->pendaftaran->pasien->jenis_kelamin=='pria'?'Laki Laki':'Perempuan' }}</td>
            </tr>
            <tr valign="top">
                <td width="120">Alamat</td>
                <td>:</td>
                <?php
                $wilayahAdministratif = $surat->pendaftaran->pasien->wilayahAdministratifIndonesia;
                ?>
                <td align="left">{{ $surat->pendaftaran->pasien->alamat }}
                    <br>Desa: {{ $wilayahAdministratif['village_name']}}<br>Kecamatan : {{ $wilayahAdministratif['district_name']}}<br>kabupaten : {{$wilayahAdministratif['regency_name'].' , '.$wilayahAdministratif['province_name']}}
                </td>
            </tr>
        </table>
        <br>
        Dengan hasil pemeriksaan sebagai berikut : 

        <br>
        <p style="text-align:justify">
            <b>Anamnesa</b> : {{ $surat->pendaftaran->anamnesa }}
        </p>
        <p>Pada pemeriksaan yang kami lakukan secara fisik diagnostik kami menerangkan : </p>


        <table>
            <tr>
                <td width="120">1. Kesadaran</td>
                <td>:</td>
                <td width="120" align="left"> {{ $surat->pendaftaran->tanda_tanda_vital['kesadaran']??0 }} mmHg</td>
                <td width="120">5. RR</td>
                <td>:</td>
                <td align="left"> {{ $surat->pendaftaran->tanda_tanda_vital['rr'] }} mmHg</td>
            </tr>
            <tr>
                <td width="120">2. TD</td>
                <td>:</td>
                <td align="left"> {{ $surat->pendaftaran->tanda_tanda_vital['tekanan_darah'] }} x/Menit </td>
                <td width="120">6. Sp02</td>
                <td>:</td>
                <td align="left"> {{ $surat->pendaftaran->tanda_tanda_vital['saturasi_o2'] }} mmHg</td>
            </tr>
            <tr>
                <td width="120">3. Nadi</td>
                <td>:</td>
                <td align="left"> {{ $surat->pendaftaran->tanda_tanda_vital['nadi'] }} Kg</td>
                <td width="120">7. Suhu</td>
                <td>:</td>
                <td align="left"> {{ $surat->pendaftaran->tanda_tanda_vital['suhu_tubuh'] }} Celcius</td>
            </tr>
            <tr>
                <td width="120">4. Lain Lain</td>
                <td>:</td>
                <td align="left">{{ $surat->lain_lain }}</td>
            </tr>
        </table>
        <table>
            <tr valign="top">
                <td width="120">Pemeriksaan Penunjang</td>
                <td>
                    <table>
                        <tr>
                            <td width="20"><input type="checkbox"></td>
                            <td>Laboratorium</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox"></td>
                            <td>Radiologi</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox"></td>
                            <td>Lainya : </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>Diagnosa Sementara</td>
                <td> : {{ $surat->diagnosa_sementara }}</td>
            </tr>
            <tr>
                <td>Tindakan Yang Diberikan</td>
                <td> : {{ $surat->tindakan_yang_telah_dilakukan }}</td>
            </tr>
            <tr>
                <td>Terapi Yang Diberikan</td>
                <td> : {{ $surat->terapi_yang_telah_diberikan }}</td>
            </tr>
        </table>

        <p>Mohon dilakukan pemeriksaan dan penanganan lebih lanjut, Atas kerjasamanya kami ucapkan terima kasih.</p>
        <div style="float: right">
            <p style="margin-right:90px;margin-bottom:70px">Cibinong, {{ date('d M Y')}}<br>Dokter Pemeriksa</p>
            <br>
            <br>

            @include('surat.ttd_dokter')
        </div>
    </div>

</body>

</html>