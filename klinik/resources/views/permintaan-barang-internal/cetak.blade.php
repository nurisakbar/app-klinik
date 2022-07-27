<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Permintaan Barang Internal</title>
    <style>
        .title-header {
            font-size:25px;
            font-weight: bold;
            text-align: center;
            margin-bottom : 5%
        }
        .title-referensi{
            float: right;
            font-size:15px
        }
        .info{
            padding-top:150px;
            font-size:15px
        }
        .table-responsive{
            padding-top: 40px;
            font-size:15px
        }
        .table-barang{
            width: 100%;
            border: 1px solid #ffffff;
            text-align: center;
            border-collapse: collapse;
        }
        .table-barang tr th{
            background-color:  #03537a;
            color: #ffffff;
            height: 30px;
        }
        .table-barang tr td{
            height: 35px;
            background-color:   #f1f2f2 
        }
        .detail-harga{
            width: 100%;
            padding-top: 50px;
            font-size:15px
        }
        .syarat-dan-ketentuan{
            width: 100%;
            padding-top: 5%;
            font-size:15px
        }
    </style>
</head>
<body  style="font-family: 'sans-serif;">
    
    <div class="container">
        <div class="title-header">
            Permintaan Barang Internal
        </div>
        <div class="title-referensi">
            <table style="width: 100%">
                <tr>
                    <td  style="width: 50%">
                        <table  style="width: 100%">
                            <tr align="left">
                                <td style="width: 40%:"><strong>Permintaan dari unit</strong></td>
                                <td style="width: 60%:"> : {{ $permintaan_barang_internal->unitSumber->nama_unit }}</td>
                            </tr>
                            <tr align="left">
                                <td style="width: 40%:"><strong>Unit yang diminta</strong></td>
                                <td style="width: 60%:"> : {{ $permintaan_barang_internal->unitTujuan->nama_unit }}</td>
                            </tr>
                            <tr align="left">
                                <td style="width: 70%:"><strong>Tanggal</strong></td>
                                <td style="width: 30%:"> : {{ $permintaan_barang_internal->tanggal }}</td>
                            </tr>
                        </table>
                    </td>
                    <td style="width: 50%">
                        <!-- <img src="https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png" alt="" style="width:100%"> -->
                    </td>
                </tr>
            </table>
        </div>

        <div class="table-responsive" style="margin-top:5%">
            <table cellspacing="1" cellpadding="10" class="table-barang">
                <tr>
                    <th>No</th>
                    <th>Kode Barang</th>
                    <th>Barang</th>
                    <th>Jumlah Diminta</th>
                    <th>Jumlah Diterima</th>
                </tr>
                @php $diminta = 0; $diterima = 0 @endphp
                @foreach($permintaan_barang_detail as $row)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $row->barang->kode }}</td>
                    <td>{{ $row->barang->nama_barang }}</td>
                    <td>{{ $row->jumlah_diminta }}</td>
                    <td>{{ $row->jumlah_diterima }}</td>
                </tr>
                @php 
                    $diminta = $diminta + $row->jumlah_diminta ; 
                    $diterima = $diterima + $row->jumlah_diterima ; 
                @endphp
                @endforeach
                <tr style="border-top : 1px solid #9a9a9a">
                    <td></td>
                    <td></td>
                    <td>Total</td>
                    <td>{{ $diminta }}</td>
                    <td>{{ $diterima }}</td>
                </tr>
            </table>
        </div>

        <div class="syarat-dan-ketentuan">
            <table style="width: 100%">
                <tr>
                    <td style="width: 50%"></td>
                    <td style="width: 30%" align="center">
                        <div style="margin-bottom : 15%">
                            {{ date('d F Y') }}
                        </div> 
                        {{ucWords($permintaan_barang_internal->unitSumber->nama_unit)}}
                    </td>
                </tr>
            </table>
        </div>
    </div>

</body>
</html>