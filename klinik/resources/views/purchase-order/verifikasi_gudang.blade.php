@extends('layouts.app')
@section('title','Purchase Order (PO)')
@section('content')
<style>
  .dataTables_scrollHeadInner{
      width: 100% !important;
  }
  table.dataTable{
      width: 100% !important;
  }
</style>
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Verifikasi Terima Barang Purchase Order
        <small>Purchase Order {{$purchase_order->kode}}</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="/purchase-order"> Purchase Order</a></li>
        <li class="active">{{$purchase_order->kode}}</li>
      </ol>
    </section>


    <section class="content">
      @include('alert')
        <div class="row">
          <div class="col-md-12">
              <div class="box">
               
                  <div class="box-body">
                      <table class="table table-bordered">
                          <tr>
                              <td width="140">Kode PO</td><td>: {{$purchase_order->kode}}</td>
                          </tr>
                          <tr>
                              <td>Tanggal Pengajuan</td><td>: {{tgl_indo($purchase_order->tanggal)}}</td>
                          </tr>
                          <tr>
                              <td>Supplier</td><td>: {{$purchase_order->supplier->nama_supplier}}</td>
                          </tr>
                      </table>
                    <br>
                      <div class="callout callout-info" role="alert">
                        <b>Informasi</b> : Silahkan verifikasi jumlah barang yang diterima dari vendor, ketika button selesai diklik maka akan melakukan update stock secara otomatis.
                      </div>
                      <div class="table-responsive" style='margin-top : 8px'>
                          <table class="table table-bordered">
                              <thead>
                                  <tr>
                                      <th>#</th>
                                      <th>Kode Barang</th>
                                      <th>Nama Barang</th>
                                      <th>Jumlah Diminta</th>
                                      <th>Jumlah Diterima</th>
                                      <th>Harga PO</th>
                                      <th>Diskon</th>
                                      <th>Harga Diskon</th>
                                      <th>Subtotal</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <?php $total = 0; ?>
                                  @foreach($purchase_order_detail as $row)
                                  <tr>
                                      <th scope="row">{{ $loop->iteration }}</th>
                                      <td>{{ $row->barang->kode }}</td>
                                      <td>{{ $row->barang->nama_barang }}</td>
                                      <td>{{ $row->qty }}</td>
                                      <td>
                                          <a href="#" class="editableRow" data-pk = '{{$row->id}}' data-name='qty_diterima'>
                                              {{$row->qty_diterima ? : 0}}
                                          </a>
                                      </td>
                                      <td>@currency($row->harga)</td>
                                      <td>{{ rupiah($row->diskon) }} %</td>
                                      <td>{{ rupiah(($row->harga-($row->diskon/100)*$row->harga)) }}</td>
                                      <td>{{ rupiah(($row->harga-($row->diskon/100)*$row->harga)*$row->qty) }}</td>
                                  </tr>
                                  <?php $total += ($row->harga-($row->diskon/100)*$row->harga)*$row->qty?>
                                  @endforeach
                              </tbody>
                              <tfoot>
                                <tr>
                                    <td></td>
                                    <td colspan="7" class="text-right">Diskon</td>
                                    <td colspan="1">{{$purchase_order->diskon}}</td>
                                </tr>
                                <?php $total = $total- $purchase_order->diskon;?>
                                  <tr>
                                      <td></td>
                                      <td colspan="7" class="text-right">Total</td>
                                      <td colspan="1">@currency($total)</td>
                                  </tr>
                              </tfoot>
                          </table>
                          <a href="/purchase-order/verify/{{$purchase_order->id}}" class='btn btn-success pull-right'><i class="fa fa-check"></i>Selesai</a>
                      </div>
                  </div>
              </div>
          </div>
        </div>
      </section>
  </div>
@endsection

@push('scripts')
<script src="{{asset('/select2/dist/js/select2.min.js')}}"></script>
<script src="{{asset('bootstrap3-editable/js/bootstrap-editable.js')}}"></script>
<script>
    $(document).ready(() => {
        $('.editableRow').editable({
            type: 'text',
            value: '',
            placeholder : '0',
            url: '/ajax/purchase-order-edittable',
            title: 'Jumlah yang diterima'
        });
    })
</script>
@endpush

@push('css')
    <link href="{{asset('/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
    <link href="{{asset('bootstrap3-editable/css/bootstrap-editable.css')}}" rel="stylesheet">
@endpush