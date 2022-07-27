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
        Detail Purchase Order 
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
          <div class="col-md-3">
            <div class="box">
                <div class="box-header text-center" style="border-bottom: 1px solid;padding-top: 0;">
                    <h3>Persetujuan PO</h3>
                </div>
                <div class="box-body">
                    {{ Form::open(['route' => ['purchase-order.approval', $purchase_order->id]]) }}
                    {{ Form::hidden('approval',null,['id' => 'approval']) }}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="text-sm" style ="color:#393E46">Catatan Umum (optional) </label>
                                {{ Form::textarea('alasan',$purchase_order->alasan,['class' => 'form-control']) }}
                            </div>
                        </div>
                    </div>
                   
                    <div class="row">
                        <div class="col-md-12 pull-right">
                            @if($purchase_order->status_po != 'approve_by_pimpinan')
                                <button onClick="$('#approval').val(0)" class="btn btn-danger btn-sm"><i class="fa fa-ban"></i> Tolak</button>
                                <button onClick="$('#approval').val(1)" class="btn btn-warning btn-sm"><i class="fa fa-check"></i> Selesai</button>
                            @endif
                            <a href="/purchase-order" class="btn btn-danger btn-sm">Kembali</a>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
          </div>

          <div class="col-md-9">
              <div class="box">
                  <div class="box-header text-center">
                      <h3>Keterangan Purchase Order</h3>
                  </div>
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
                      <div class="table-responsive">
                          <table class="table table-bordered">
                              <thead>
                                  <tr>
                                      <th>#</th>
                                      <th>Nama Barang</th>
                                      <th>Satuan</th>
                                      <th>Jumlah</th>
                                      <th>Harga PO</th>
                                      <th>Diskon %</th>
                                      <th>Harga Diskon</th>
                                      <th>Subtotal</th>
                                      <th width="200">Catatan ( Opsional )</th>
                                      @if($purchase_order->status_po=='menunggu_persetujuan')
                                        <th width="80">Action</th>
                                      @endif
                                  </tr>
                              </thead>
                              <tbody>
                                  <?php $total = 0; ?>
                                  @foreach($purchase_order_detail as $row)
                                  <tr class="table-danger" id="baris-{{$row->id}}">
                                      <th scope="row">{{ $loop->iteration }}</th>
                                      <td>{{ $row->barang->nama_barang }}</td>
                                      <td>{{ $row->satuan->satuan??'-' }}</td>
                                      <td>{{ $row->qty }}</td>
                                      <td>@currency($row->harga)</td>
                                      <?php
                                      $harga_diskon = (($row->diskon/100)*$row->harga);
                                      ?>
                                      <td>{{$row->diskon}} % ( Rp. {{ rupiah($harga_diskon) }} )</td>
                                      <td>{{ rupiah(($row->harga-$harga_diskon)) }}</td>
                                      <td>{{ rupiah(($row->harga-$harga_diskon)*$row->qty) }}</td>
                                      <td>
                                          {!! Form::text('catatan', $row->catatan, ['class'=>'form-control catatan-'.$row->id,'Placeholder'=>'Keterangan']) !!}
                                      </td>
                                      @if($purchase_order->status_po=='menunggu_persetujuan')
                                        <td>
                                            <i class="fa fa-check-square-o fa-2x" aria-hidden="true" onClick="approval({{$row->id}},1)"></i>
                                            <i class="fa fa-times fa-2x" aria-hidden="true" onClick="approval({{$row->id}},0)"></i>
                                        </td>
                                      @endif
                                  </tr>
                                  <?php $total += ($row->harga-$harga_diskon) * $row->qty;?>
                                  @endforeach
                              </tbody>
                              <tfoot>
                                <tr>
                                    <td></td>
                                    <td colspan="6" style="text-align:right"><b>Subtotal</b></td>
                                    <td colspan="2">
                                        <span id="disc">
                                            {{$total}}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="6" style="text-align:right"><b>Diskon</b></td>
                                    <td colspan="2">
                                        <span id="disc">
                                            {{$purchase_order->diskon}}
                                        </span>
                                    </td>
                                </tr>
                                  <tr>
                                      <td></td>
                                      <td colspan="6" style="text-align:right"><b>Total Akhir</b></td>
                                      <td colspan="2">
                                          <span id="total">
                                            @currency($total-$purchase_order->diskon)
                                          </span>
                                      </td>
                                  </tr>
                              </tfoot>
                          </table>
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
<script>
    function approval(id,approval)
    {
        if(approval==1)
        {
            $("#baris-"+id).removeClass("danger").addClass("success");
            
        }else{
            $("#baris-"+id).removeClass("success").addClass("danger");
        }

        $.ajax({
            url: "/ajax/approval-item-purchase-order",
            data: {
                id: id,
                approval: approval,
                catatan: $(".catatan-"+id).val()
            },
            success: function (response) {
                console.log(response.total);
                var diskon = {{ $purchase_order->diskon}};
                var total = response.total-diskon;
                console.log(total);
                $('#total').html(total);
            }
        });
    }
</script>
@endpush

@push('css')
    <link href="{{asset('/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
@endpush