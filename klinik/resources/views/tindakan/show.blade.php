@extends('layouts.app')
@section('title','Tindakan '.$tindakan->tindakan)
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
            Detail Tindakan
            <small>Detail tindakan {{$tindakan->tindakan}} </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/tindakan">Tindakan </a></li>
            <li class="active">{{$tindakan->tindakan}}</li>
        </ol>
    </section>

    <section class="content">
        @include('alert')
        <div class="row">
            <div class="col-md-5">
                <div class="box">
                    <div class="box-header text-center" style="border-bottom: 1px solid;padding-top: 0;">
                        <h3>Tindakan</h3>
                    </div>
                    <div class="box-body">
                        {{ Form::open(['route'=>['tindakan.update', $tindakan->id], 'id' => 'form_parent', 'method' => 'PUT']) }}
                        {{ Form::hidden('permintaan_barang_internal_id', null, ['id' => 'parent_id']) }}
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Kode ICD</label>
                                    {{ Form::text('kode',$tindakan->icd->code??'-',['class' => 'form-control', 'disabled']) }}
                                </div>
                                <div class="form-group">
                                    <label>Nama ICD</label>
                                    {{ Form::text('kode',$tindakan->icd->desc_short??'-',['class' => 'form-control', 'disabled']) }}
                                </div>
                                <div class="form-group">
                                    <label>Nama Tindakan</label>
                                    {{ Form::text('tindakan',$tindakan->tindakan,['class' => 'form-control', 'required']) }}
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Tarif Umum</label>
                                            {{ Form::text('kode',$tindakan->tarif_umum,['class' => 'form-control', 'disabled']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Tarif BPJS</label>
                                            {{ Form::text('kode',$tindakan->tarif_bpjs,['class' => 'form-control', 'disabled']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Tarif Perusahaan</label>
                                            {{ Form::text('kode',$tindakan->tarif_perusahaan,['class' => 'form-control', 'disabled']) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="padding-bottom: 30px;margin: -10px;padding-top: 12px;">
                            <div class="col-md-8">
                                <a href="{{ route('tindakan.index')}}" class="btn btn-success btn-sm">
                                    <i class="fa fa-arrow-left"></i> Kembali</a>
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-save"></i>
                                    Update</button>
                                    @if($tindakan->jenis=='tindakan_laboratorium')
                                        <a href="/tindakan/{{$tindakan->id}}?tab=indikator" class="btn btn-danger btn-sm">Input Indikator</a>
                                    @endif
                            </div>
                        </div>
                        {{ Form::close() }}

                    </div>
                </div>
            </div>

            <div class="col-md-7">
                <div class="box">
                    <div class="box-header text-center" style="border-bottom: 1px solid;padding-top: 0;">
                        <h3>Alat Kesehatan ( Habis Pakai )</h3>
                    </div>
                    <div class="box-body">
                        <div class="row" style="padding-bottom: 20px">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Pilih Barang</label>
                                    <select name="barang" class="barang form-control detail-section"></select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Jumlah</label>
                                    {{ Form::text('qty', null, ['class' => 'form-control qty detail-section', 'placeholder' => 'qty', 'required']) }}
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Satuan</label>
                                    {!! Form::select('satuan_id',$satuan, null, ['class'=>'form-control satuan_id']) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <button id="tambah_barang_detail" type="button" onClick="tambah_barang()"
                                        class="btn btn-primary detail-section" style="margin-top: 25px;">
                                        <i class="fa fa-plus"></i> Tambah
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive" id="table-detail-section">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Kode Barang</th>
                                        <th scope="col">Nama Barang</th>
                                        <th scope="col">Jumlah Dipakai</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="3" style="text-align:right">Total</td>
                                        <td>-</td>
                                    </tr>
                                </tbody>
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
<!-- DataTables -->
<script src="{{asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('adminlte/bower_components/select2/dist/js/select2.min.js')}}"></script>
<script>
$( document ).ready(function() {
	refresh_table()
    $('.barang').select2({
        placeholder: 'Cari Nama Barang',
        ajax: {
        url: '/ajax/select2Barang',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
            return {
            results:  $.map(data, function (item) {
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

function hapus_barang(barang_id = null)
{
	if(barang_id == null){
		barang_id = $(".barang").val();
	}

	$('.btn-hapus-barang').prop('disabled', true)
	
	$.ajax({
		url: "/tindakan-bhp/"+barang_id,
		type: "DELETE",
		data: {
			_token: $('meta[name="csrf-token"]').attr('content'),
			barang_id: barang_id
		},
		success: function (response) {
			refresh_table()
		},
		error: function () {
			alert("error");
		}

	});
}

function refresh_table(hasResponse = null){
	if(hasResponse != null){
		return $('#table-detail-section').html(hasResponse)
	}
    
	$.ajax({
		url : "/tindakan-bhp/{{$tindakan->id}}",
		type : "GET",
		success : (response)=>{
			$('#table-detail-section').html(response)
            $('#datatable').DataTable()
		}
	})
}

function ubahJumlah(id){
        console.log(id);
        $.ajax({
		url : "/ajax/ubah-jumlah-bhp",
        data: {
			_token: $('meta[name="csrf-token"]').attr('content'),
			id: id,
            jumlah:$("#jumlah-"+id).val()
		},
		type : "POST",
		success : (response)=>{
            console.log(response);
		}
	})
    }

function tambah_barang() {

    var barang_id   = $(".barang").val();
    var qty         = $(".qty").val();
    var satuan_id   = $(".satuan_id").val();
    if(barang_id == '' || qty == '')
    {
      return alert('Barang Atau Jumlah Tidak Boleh Kosong');
    }

    $.ajax({
        url: "/tindakan-bhp",
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            barang_id: barang_id,
            jumlah: qty,
            satuan_id:satuan_id,
            tindakan_id : '{{$tindakan->id}}'
        },
        success: function (response) {
            refresh_table(response)
            $('#datatable').DataTable()
        },
        error: function () {
            alert("error");
        }

    });
}
</script>
@endpush

@push('css')
<link href="{{asset('adminlte/bower_components/select2/dist/css/select2.min.css')}}" rel="stylesheet"/>  
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
@endpush