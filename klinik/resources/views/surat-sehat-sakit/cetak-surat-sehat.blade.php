<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Keterangan Sehat</title>
    <style>
        .text-center {
            text-align: center;
        } 
        .mt-3 {
            margin-top: 30px;
        }
    </style>
</head>
<body>

    <h1 class="text-center"><u>Surat Keterangan Sehat</u></h1>

    <div class="mt-3">
        <p>Yang bertanda tangan dibawah ini Dokter Pemeriksa Klinik Nur Wahid menerangkan</p>
        <div style="margin-left: 50px;">
            <table>
                <tr>
                    <td style="padding-right: 20px">Nama</td>
                    <td >:</td>
                    <th align="left">{{ $surat->pasien->nama }}</th>
                </tr>   
                <tr>
                    <td style="padding-right: 20px">Jenis Kelamin</td>
                    <td >:</td>
                    <th align="left">{{ ucfirst($surat->pasien->jenis_kelamin) }}</th>
                </tr>   
                <tr>
                    <td style="padding-right: 20px">Pekerjaan</td>
                    <td >:</td>
                    <th align="left">{{ $surat->pasien->pekerjaan }}</th>
                </tr>   
                <tr>
                    <td style="padding-right: 20px">Alamat</td>
                    <td >:</td>
                    <th align="left">{{ ucfirst($surat->pasien->alamat) }}</th>
                </tr>   
            </table>
        </div>
        <p>Hasil pemeriksaan fisik oleh kami pada tanggal {{ date('d F Y', strtotime($surat->tanggal_mulai)) }} di Klinik </p>
        <p> Nur Wahid adalah sebagai berikut :</p>
        <div style="margin-left: 50px;">
            <table>
                <tr>
                    <td style="padding-right: 20px">Berat Badan</td>
                    <td >:</td>
                    <th align="left">{{ $surat->pasien->nama }}</th>
                </tr>   
                <tr>
                    <td style="padding-right: 20px">Tinggi Badan</td>
                    <td >:</td>
                    <th align="left">{{ ucfirst($surat->pasien->jenis_kelamin) }}</th>
                </tr>   
                <tr>
                    <td style="padding-right: 20px">Tekanan Darah</td>
                    <td >:</td>
                    <th align="left">{{ $surat->pasien->pekerjaan }}</th>
                </tr>   
                <tr>
                    <td style="padding-right: 20px">Golongan Darah</td>
                    <td >:</td>
                    <th align="left">{{ ucfirst($surat->pasien->alamat) }}</th>
                </tr>   
            </table>
        </div>
        <p>Surat Keterangan Sehat ini dipergunakan sebagai <strong>{{ $surat->keperluan }}</strong></p>
        <p>Demikian surat keturunan ini dibuat untuk dapat dipergunakan sebagaimana mestinya.</p>
    </div>
    
</body>
</html>