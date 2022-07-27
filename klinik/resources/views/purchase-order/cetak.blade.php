<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Purchase Order</title>
    <style>
        .title-header {
            font-size:25px;
            font-weight: bold;
            text-align: right
        }
        .title-referensi{
            float: right;
            font-size:13px
        }
        .info{
            padding-top:150px;
            font-size:13px
        }
        .table-responsive{
            padding-top: 40px;
            font-size:13px
        }
        .table-barang{
            width: 100%;
            border: 1px solid #ffffff;
            text-align: center
        }
        .table-barang tr th{
            background-color:  #03537a;
            color: #ffffff;
            height: 20px;
        }
        .table-barang tr td{
            height: 20px;
            background-color:   #f1f2f2 
        }
        .detail-harga{
            width: 100%;
            padding-top: 30px;
            font-size:13px
        }
        .syarat-dan-ketentuan{
            width: 100%;
            font-size:13px
        }
    </style>
</head>
<body  style="font-family: 'sans-serif;">
    
    <div class="container">
        <div class="title-header">
            Purchase Order
        </div>
        <div class="title-referensi">
            <table style="width: 100%">
                <tr>
                    <td style="width: 50%">
                        <img src="image/{{ $setting->logo }}" alt="" style="width:30%">
                    </td>
                    <td  style="width: 50%">
                        <table  style="width: 100%">
                            <tr align="right">
                                <td style="width: 40%:"><strong>Referensi</strong></td>
                                <td style="width: 60%:">{{ $purchase_order->kode }}</td>
                            </tr>
                            <tr align="right">
                                <td style="width: 70%:"><strong>Tanggal</strong></td>
                                <td style="width: 30%:">{{ $purchase_order->tanggal }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>

        <div class="info">
            <table style="width: 100%">
                <tr>
                    <td style="width: 45%:">
                        Info Perusahaan
                        <hr>
                        <strong>{{ $setting->nama_instansi }}</strong>

                        <div style="padding-top: 30px">
                            <span>{{ $setting->nomor_telpon }}</span><br>
                            <span>{{ $setting->alamat }}</span>
                        </div>
                    </td>
                    <td style="width:10%"></td>
                    <td style="width: 45%:">
                        Info Supplier
                        <hr>
                        <strong>{{ $purchase_order->supplier->nama_supplier }}</strong>

                        <div  style="padding-top: 30px">
                            <span>{{ $purchase_order->supplier->nomor_telpon }}</span><br>
                            <span>{{ $purchase_order->supplier->alamat }}</span>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="table-responsive">
            <table cellspacing="1" cellpadding="10" class="table-barang">
                <tr>
                    <th>No</th>
                    <th>Barang</th>
                    <th>Jumlah</th>
                    <th>Disc %</th>
                    <th>Harga</th>
                    <th>Harga Diskon</th>
                    <th>Subtotal</th>
                </tr>
                <?php $total = 0; ?>
                @foreach($purchase_order_detail as $row)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $row->barang->nama_barang }}</td>
                    <td>{{ $row->qty }} {{ $row->satuan->satuan }}</td>
                    <td>{{ rupiah($row->diskon) }} %</td>
                    <td>{{rupiah($row->harga)}}</td>
                    <td>{{ rupiah(($row->harga-($row->diskon/100)*$row->harga)) }}</td>
                    <td>{{ rupiah(($row->harga-($row->diskon/100)*$row->harga)*$row->qty) }}</td>
                </tr>
                <?php $total +=  ($row->harga-(($row->diskon/100)*$row->harga))*$row->qty ?>
                @endforeach
                <tr>
                    <td colspan="5">Diskon</td>
                    <td colspan="2">{{rupiah($purchase_order->diskon)}}</td>
                </tr>
            </table>
        </div>

        <div class="detail-harga">
            <table style="width: 100%">
                <tr align="right">
                    <td style="width: 70%:"><strong>Total</strong></td>
                    <td style="width: 30%:">@currency($total-$purchase_order->diskon)</td>
                </tr>
            </table>
        </div>

        <div class="syarat-dan-ketentuan">
            <table style="width: 100%">
                {{-- <tr>
                    <td style="width: 100%:">Syarat dan ketentuan</td>
                </tr> --}}
                <tr>
                    <td>Bogor, {{ tgl_indo(date('Y-m-d')) }}</td>
                </tr>
                <tr>
                    <td>Penanggung Jawab</td>
                </tr>
                <tr>
                    <td style="width: 50%;height:190px">{{ Auth::user()->name }}<hr></td>
                </tr>
            </table>
        </div>
    </div>

</body>
</html>