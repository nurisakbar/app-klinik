<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .content{
            width: 50%;
            border: 1px solid black;
            border-style: dashed;
            padding:5px
        }
        .content-header{
            border-bottom: 1px solid black;
            padding-bottom:20px;
            padding-top:10px
        }
        .content-body{
            padding-top: 10px;
        }
        .header-left{
            text-align: left;
            width: 50%;
            font-weight: bold;
        }
        .header-right{
            text-align: right;
            width: 100%;
            margin-top: -19px;
        }
        .nomor-antrian{
            font-size: 15px;
            color: black;
            font-weight: bold;
        }
        .text-right{
            text-align: right;
            margin-top: -20px;
        }
        .text-small{
            font-size:10px
        }
        .text-right-info{
            font-size:14px;
        }
        .text-left-info{
            font-size: 14px;
            font-weight: bold;
        }
        .content-spac{
            padding-bottom: 20px;
        }
    </style>
</head>
<body style="font-family: 'sans-serif;">
    <div style="text-align:center">
        <h2 style="font-size: 3em"><u>NOMOR ANTRIAN POLIKLINIK</u></h2>
        <h2 style="font-size: 4em;margin-bottom:-20px">{{ $nomorAntrian->pendaftaran->pasien->nomor_rekam_medis }}</h2>
        <h2 style="margin-top: -15px;font-size: 4em;margin-bottom:-10px">{{  $nomorAntrian->pendaftaran->pasien->nama }}</h2>
        <h4 style="margin-top: 50px;margin-bottom:-60px;font-size: 3em">NO. URUT</h4>
        <h1 style="font-size: 5em">{{ $nomorAntrian->nomor_antrian }}</h1>
        <h1 style="font-size: 4em;margin-bottom:-20px">{{ $nomorAntrian->poliklinik->nama }}</h1>
        <h1 style="font-size: 3em">{{ $nomorAntrian->dokter->name }}</h1>
        <h2 style="margin-top: 50px;font-size: 2em"><u>SILAHKAN MENGANTRI</u></h2>
        <h2 style="font-size: 2em">KLINIK DR.NURDIN WAHID</h2>
    </div>
</body>
</html>