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
    <h4 style="text-align: center">SURAT KETERANGAN SAKIT</h4>

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
        <tr>
            <td style="padding-right: 20px">Instansi</td>
            <td>:</td>
            <th align="left">{{ $surat->instansi??'-' }}</th>
        </tr>
    </table>
    <?php
    $datetime1 = new DateTime($surat->dari_tanggal);

    $datetime2 = new DateTime($surat->sampai_tanggal);

    $difference = $datetime1->diff($datetime2)->d+1;
    ?>
    <p>
        Berdasarkan hasil pemeriksaan yang dilakukan, pasien tersebut dalam keadaan sakit, sehingga perlu istirahat selama {{ $difference }} hari. Terhitung tanggal {{ $surat->dari_tanggal }} .sd  {{ $surat->sampai_tanggal }}
        <br>Diagnosa 	: {{ $surat->diagnosa_sementara}}
        
        <br>Demikian surat keterangan ini diberikan untuk diketahui dan dipergunakan sebagaimana mestinya.	
    </p>

    
    <div style="float: right">
        <p style="margin-right:90px;margin-bottom:70px">Cibinong, {{ date('d M Y')}}<br>Dokter Pemeriksa</p>
        <br>
        <br>

        @include('surat.ttd_dokter')
    </div>

</body>

</html>