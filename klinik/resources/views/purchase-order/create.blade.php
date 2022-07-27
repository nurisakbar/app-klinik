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
        Tambah Purchase Order 
        <small>Buat baru Purchase Order</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="/purchase-order"> Purchase Order</a></li>
        <li class="active">Tambah</li>
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
                <input type="hidden" name="diskon" id="diskon">

                  <div class="row">

                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Kode PO</label>
                        {{ Form::text('',generateKodePurchaseOrder(),['class' => 'form-control', 'required','readonly']) }}
                    </div>
                        <div class="form-group">
                            <label>Tanggal Pengajuan</label>
                            {{ Form::date('tanggal',date('Y-m-d'),['class' => 'form-control', 'required']) }}
                        </div>
                   
                        <div class="form-group">
                            <label>Supplier</label>
                            {{ Form::select('supplier_id', $supplier, null,['class' => 'form-control']) }}
                        </div>
                    </div>
                  </div>

                  <div class="row" style="padding-bottom: 30px;margin: -10px;padding-top: 12px;">
                    <div class="col-md-8">
                        <a href="{{ route('purchase-order.index')}}" class="btn btn-success btn-sm">Kembali</a>
                        <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-save"></i> Simpan</button>
                    </div>
                  </div>
                {{ Form::close() }}
              </div>
            </div>
          </div>

          <div class="col-md-8">
            <div class="box">
                <div class="box-header text-center" style="border-bottom: 1px solid;padding-top: 0;">
                    <h3>Tambah Barang</h3>
                </div>
              <div class="box-body">
                  <div class="row" style="padding-bottom: 20px">
				 	          <div class="col-md-3">
                        <div class="form-group">
                            <label>Pilih Barang</label>
                            <select name="barang" id="barang" class="barang form-control detail-section"></select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Harga</label>
                            {{ Form::text('harga', null, ['class' => 'form-control harga detail-section', 'id'=>'harga', 'placeholder' => 'Harga', 'required']) }}
                        </div>
                    </div>
                    <div class="col-md-1" style="margin-right:20px;">
                      <div class="form-group">
                        <label>Disc</label>
                        <div class="input-group">
                          {{ Form::text('', 0, ['class' => 'form-control diskon', 'id' => 'diskon', 'placeholder' => 'Diskon', 'required','style' => 'width:50px']) }}
                          <span class="input-group-addon" id="basic-addon3">%</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-1">
                      <div class="form-group">
                        <label>Qty</label>
                        {{ Form::text('qty', null, ['class' => 'form-control qty', 'id' => 'qty', 'placeholder' => 'qty', 'required']) }}
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>Satuan</label>
                        {{ Form::select('satuan_id',$satuan, null, ['class' => 'form-control satuan_id', 'required']) }}
                      </div>
                    </div>
                    <div class="col-md-1">
                      <div class="form-group">
                        <button type="button" onClick="tambah_barang()" class="btn btn-primary" style="margin-top: 25px;"><i class="fa fa-plus"></i></button>
                      </div>
                    </div>
                  </div>
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
    list_barang();
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
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });
});


function copyDiskon(){
  var valDis = $(".disc").val();
  $("#diskon").val(valDis);
  var total         = $("#jumlah_total").val();
  var diskon        = $(".disc").val();
  $(".txt_diskon").html(total - diskon);
}
function ubah_baris(barang_id = null, nama_barang = null, harga = null, qty = null){
    $("#barang option").remove()
    $("#barang").append(new Option(nama_barang, barang_id))
    $("#harga").val(harga)
    $("#qty").val(qty)
}


function list_barang(){
  $.ajax({
      url: "/purchase-order-detail",
      type: "GET",
      success: function (response) {
          $("#table_barang").html(response);
          $('.editableRow').editable({
              type: 'text',
              value : '',
              url: '/ajax/purchase-order-edittable',
              title: 'Masukan data baru'
          });
          $('.editableRow').on('save', (e, editable) => {
            list_barang()
          })
      },
      error: function (err) {
        console.log('error', err)
      }

  });
}



function tambah_barang()
{
  var barang_id = $(".barang").val();
  var qty       = $(".qty").val();
  var harga     = $(".harga").val();
  var diskon    = $(".diskon").val();
  var satuan_id = $(".satuan_id").val();
  if(barang_id == '' || qty == '' || harga == '')
  {
    return alert('Barang , jumlah, atau harga Tidak Boleh Kosong');
  }
  $.ajax({
      url: "/purchase-order-detail",
      type: "POST",
      data: {
          _token: $('meta[name="csrf-token"]').attr('content'),
          barang_id: barang_id,
		      harga:harga,
          satuan_id: satuan_id,
          diskon: diskon,
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
  console.log(id);
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