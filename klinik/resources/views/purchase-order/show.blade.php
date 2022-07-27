@extends('layouts.app')
@section('title','Purchase Order (PO)')
@section('content')
<style>
    .dataTables_scrollHeadInner {
        width: 100% !important;
    }

    table.dataTable {
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
            <div class="col-md-4">
                <div class="box">
                    <div class="box-header text-center" style="border-bottom: 1px solid;padding-top: 0;">
                        <h3>Purchase Order (PO)</h3>
                    </div>
                    <div class="box-body">
                        {{ Form::open(['route' => 'purchase-order.store']) }}
                        {{ Form::hidden('kode',generateKodePurchaseOrder()) }}
                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Kode PO</label>
                                    {{ Form::text('',$purchase_order->kode,['class' => 'form-control', 'required','readonly']) }}
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Pengajuan</label>
                                    {{ Form::date('tanggal',$purchase_order->tanggal,['class' => 'form-control', 'readonly']) }}
                                </div>

                                <div class="form-group">
                                    <label>Supplier</label>
                                    {{ Form::text('',$purchase_order->supplier->nama_supplier,['class' => 'form-control', 'required','readonly']) }}
                                </div>

                            </div>
                        </div>

                        <div class="row" style="padding-bottom: 30px;margin: -10px;padding-top: 12px;">
                            <div class="col-md-8">
                                <a href="{{ route('purchase-order.index')}}" class="btn btn-success btn-sm">Kembali</a>
                                <a href="/purchase-order/{{ $purchase_order->id}}/cetak" class="btn btn-danger btn-sm" target="new">Cetak</a>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="box">
                    <div class="box-header text-center" style="border-bottom: 1px solid;padding-top: 0;">
                        <h3>Data Barang</h3>
                    </div>
                    <div class="box-body">
                        @if(!in_array($purchase_order->status_po,['selesai_po','approve_by_pimpinan']))
							<div class="row " style="padding-bottom: 20px">
								<div class="col-md-4">
									<div class="form-group">
										<label>Pilih Barang</label>
										<select name="barang" id="barang"
											class="barang form-control "></select>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label>Harga</label>
										{{ Form::text('harga', null, ['class' => 'form-control harga ', 'id'=>'harga', 'placeholder' => 'Harga', 'required']) }}
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label>Qty</label>
										{{ Form::text('qty', null, ['class' => 'form-control qty ', 'id' => 'qty', 'placeholder' => 'qty', 'required']) }}
									</div>
								</div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                      <label>Diskon Item</label>
                                      {{ Form::text('', 0, ['class' => 'form-control diskon', 'id' => 'diskon', 'placeholder' => 'Diskon', 'required']) }}
                                    </div>
                                  </div>
								<div class="col-md-2">
									<div class="form-group">
										<button type="button" onClick="tambah_barang()"
											class="btn btn-primary " style="margin-top: 25px;"><i
												class="fa fa-plus"></i> Tambah</button>
									</div>
								</div>
							</div>
						@endif
                        <div class="table-responsive">
                            <div id="table_barang"></div>
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
$(document).ready(function () {
	let isApprove = 0
	@if($purchase_order->status_po == 'approve_by_pimpinan')
		isApprove = 1
	@endif
	list_barang(isApprove);

    $('.barang').select2({
        placeholder: 'Cari Nama Barang',
        ajax: {
            url: '/ajax/select2Barang',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.nama_barang,
                            harga: item.harga,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });

    $('#barang').on('change', ()=>{
        let source = $("#barang :selected").data().data.harga;
        $("#harga").val(source)
    })
});

function ubah_baris(barang_id = null, nama_barang = null, harga = null, qty = null){
    $("#barang option").remove()
    $("#barang").append(new Option(nama_barang, barang_id))
    $("#harga").val(harga)
    $("#qty").val(qty)
}


function list_barang(isApprove = 0){
  $.ajax({
      url: "/purchase-order/{{$purchase_order->id}}",
      type: "GET",
	  data : {
		  isApprove : isApprove
	  },
      success: function (response) {
		$("#table_barang").html(response);
		@if($purchase_order->status_po != 'approve_by_pimpinan')
			$('.editableRow').editable({
				type: 'text',
				value : '',
				url: '/ajax/purchase-order-edittable',
				title: 'Masukan data baru'
			});
			$('.editableRow').on('save', (e, editable) => {
				list_barang()
			})
		@endif
      },
      error: function () {
          alert("error");
      }

  });
}

function tambah_barang()
{
  var barang_id = $(".barang").val();
  var qty       = $(".qty").val();
  var harga       = $(".harga").val();
  if(barang_id == '' || qty == '' || harga == '')
  {
    return alert('Barang , jumlah, atau harga Tidak Boleh Kosong');
  }
  $.ajax({
      url: "/purchase-order-detail/{{$purchase_order->id}}",
      type: "PUT",
      data: {
          _token: $('meta[name="csrf-token"]').attr('content'),
          barang_id: barang_id,
          harga : harga,
          qty: qty
      },
      success: function (response) {
          list_barang();
      },
      error: function () {
          alert("error");
      }

  });
}


function hapus_barang(id)
{
  $.ajax({
      url: "/purchase-order-detail/"+id,
      type: "DELETE",
      data: {
          _token: $('meta[name="csrf-token"]').attr('content')
      },
      success: function (response) {
        console.log(response);
        list_barang();
      },
      error: function () {
          alert("error");
      }

  });
}
</script>
@endpush

@push('css')
    <link href="{{asset('bootstrap3-editable/css/bootstrap-editable.css')}}" rel="stylesheet">
    <link href="{{asset('/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
@endpush