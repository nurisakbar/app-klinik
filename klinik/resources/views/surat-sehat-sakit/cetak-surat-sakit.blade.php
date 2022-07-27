<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Keterangan Sakit</title>
    <style>
        .text-center {
            text-align: center;
        } 
        .mt-3 {
            margin-top: 30px;
        }
    </style>
</head>
<body style="border: 1px solid black;padding:10px">

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
    <hr><hr>
    <h4 class="text-center">SURAT KETERANGAN SAKIT</h4>

    <div class="mt-3">
        <p>Yang bertanda tangan dibawah ini memberitahukan bahwa :</p>
        <div style="margin-left: 50px;">
            <table>
                <tr>
                    <td style="padding-right: 20px">Nama</td>
                    <td >:</td>
                    <th align="left">{{ $surat->pasien->nama }}</th>
                </tr>   
                <tr>
                    <td style="padding-right: 20px">Usia</td>
                    <td >:</td>
                    <th align="left">{{ $age }}</th>
                </tr>   
                <tr>
                    <td style="padding-right: 20px">Alamat</td>
                    <td >:</td>
                    <th align="left">{{ ucfirst($surat->pasien->alamat) }}</th>
                </tr>   
                {{-- <tr>
                    <td style="padding-right: 20px">Instansi</td>
                    <td >:</td>
                    <th align="left">{{ $instansi->nama_perusahaan }}</th>
                </tr>    --}}
            </table>
        </div>
        <p>Berdasarkan hasil pemeriksaan yang dilakukan, pasien tersebut dalam keadaan sakit, sehingga perlu </p>
        <p>istirahat selama <b>{{ $selama }}</b> hari, mulai tanggal <b>{{ date('d F Y', strtotime($surat->tanggal_mulai)) }}</b> s/d <b>{{ date('d F Y', strtotime($surat->tanggal_selesai)) }}.</b></p>
        
        {{-- <table>
            <tr>
                <td style="padding-right: 20px">Diagnosa</td>
                <td >:</td>
                <th align="left">{{ $instansi->nama_perusahaan }}</th>
            </tr>   
        </table> --}}

        <p>Demikian surat keterangan ini diberikan untuk diketahui dan dipergunakan sebagaimana mestinya.</p>
        <div style="float: right">
            <p style="margin-right:90px;margin-bottom:70px">Bogor, .................</p>
            <p style="margin-left: 5px">{{ $surat->user->name }}</p>
        </div>
    </div>
    
</body>
</html>