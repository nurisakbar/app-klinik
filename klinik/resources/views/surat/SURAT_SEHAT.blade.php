<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Keterangan Sakit</title>
</head>

<body>

    @include('surat.kop_surat')
    <h4 style="text-align: center">SURAT SEHAT</h4>

    <table>
        <tr>
            <td style="padding-right: 20px">Nama</td>
            <td>:</td>
            <th align="left"> {{ $surat->pendaftaran->pasien->nama }}</th>
        </tr>
        <tr>
            <td style="padding-right: 20px">Tanggal Lahir, Usia</td>
            <td>:</td>
            <th align="left">{{ $surat->pendaftaran->pasien->tanggal_lahir }}, {{hitung_umur($surat->pendaftaran->pasien->tanggal_lahir)}} Tahun</th>
        </tr>
        <tr>
            <td style="padding-right: 20px">Alamat</td>
            <td>:</td>
            <th align="left">{{ $surat->pendaftaran->pasien->alamat }}</th>
        </tr>
    </table>
    <p>Pada pemeriksaan yang kami lakukan secara fisik diagnostik kami menerangkan : </p>


    <table>
        <tr>
            <td style="padding-right: 20px">Tekanan Darah</td>
            <td>:</td>
            <th align="left"> {{ $surat->pendaftaran->tanda_tanda_vital['tekanan_darah'] }} mmHg</th>
        </tr>
        <tr>
            <td style="padding-right: 20px">Nadi</td>
            <td>:</td>
            <th align="left"> {{ $surat->pendaftaran->tanda_tanda_vital['nadi'] }} x/Menit </th>
        </tr>
        <tr>
            <td style="padding-right: 20px">Tinggi Badan</td>
            <td>:</td>
            <th align="left"> {{ $surat->pendaftaran->tanda_tanda_vital['tinggi_badan'] }} Cm</th>
        </tr>
        <tr>
            <td style="padding-right: 20px">Berat Badan</td>
            <td>:</td>
            <th align="left"> {{ $surat->pendaftaran->tanda_tanda_vital['berat_badan'] }} Kg</th>
        </tr>
        <tr>
            <td style="padding-right: 20px">Suhu</td>
            <td>:</td>
            <th align="left"> {{ $surat->pendaftaran->tanda_tanda_vital['suhu_tubuh'] }} C</th>
        </tr>
        <tr>
            <td style="padding-right: 20px">Pernafasan</td>
            <td>:</td>
            <th align="left"> {{ $surat->pendaftaran->tanda_tanda_vital['rr']??0 }} X/ Menit</th>
        </tr>
        <tr>
            <td style="padding-right: 20px">Kesan</td>
            <td>:</td>
            <th align="left">{{ $surat->kesan }}</th>
        </tr>
        <tr>
            <td style="padding-right: 20px">Keterangan Ini Untuk</td>
            <td>:</td>
            <th align="left">{{ $surat->keperluan }}</th>
        </tr>
    </table>

    <p>Demikian surat keterangan ini kami buat dengan sebenarnya dan untuk digunakan sebagaimana mestinya .</p>
    <div style="float: right">
        <p style="margin-right:90px;margin-bottom:70px">Cibinong, {{ date('d M Y')}}<br>Dokter Pemeriksa</p>
        <br>
        <br>

        @include('surat.ttd_dokter')
    </div>

</body>

</html>