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
                        {{ Form::hidden('permintaan_indikator_internal_id', null, ['id' => 'parent_id']) }}
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Kode</label>
                                    {{ Form::text('kode',$tindakan->kode,['class' => 'form-control', 'required']) }}
                                </div>
                                <div class="form-group">
                                    <label>Nama Tindakan</label>
                                    {{ Form::text('tindakan',$tindakan->tindakan,['class' => 'form-control', 'required']) }}
                                </div>
                            </div>
                        </div>

                        <div class="row" style="padding-bottom: 30px;margin: -10px;padding-top: 12px;">
                            <div class="col-md-8">
                                <a href="{{ route('tindakan.index')}}" class="btn btn-success btn-sm">
                                    <i class="fa fa-arrow-left"></i> Kembali</a>
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-save"></i>
                                    Update</button>
                                <a href="/tindakan/{{$tindakan->id}}?tab=bhp" class="btn btn-danger btn-sm">Lihat BHP</a>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>

            <div class="col-md-7">
                <div class="box">
                    <div class="box-header text-center" style="border-bottom: 1px solid;padding-top: 0;">
                        <h3>{{config('datareferensi.jenis_tindakan')[$tindakan->jenis]}}</h3>
                    </div>
                    <div class="box-body">
                        <div class="row" style="padding-bottom: 20px">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Nama Indikator</label>
                                    {{ Form::text('nama_indikator', null, ['class' => 'form-control nama_indikator detail-section', 'placeholder' => 'Nama Indikator', 'required']) }}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Satuan</label>
                                    {{ Form::text('qty', null, ['class' => 'form-control satuan detail-section', 'placeholder' => 'Satuan', 'required']) }}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Nilai Rujukan</label>
                                    {{ Form::text('nilai_rujukan', null, ['class' => 'form-control nilai_rujukan detail-section', 'placeholder' => 'Nilai Rujukan', 'required']) }}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <button id="tambah_indikator_detail" type="button" onClick="tambah_indikator()"
                                        class="btn btn-primary detail-section" style="margin-top: 25px;">
                                        <i class="fa fa-plus"></i> Tambah
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive" id="table-detail-section">
                            <!-- Ajax content on view tindakan.ajax-indikator-table -->
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
<script src="{{asset('bootstrap3-editable/js/bootstrap-editable.js')}}"></script>
<script>
$( document ).ready(function() {
	refresh_table()
    $('.indikator').select2({
        placeholder: 'Cari Nama Indikator',
        ajax: {
        url: '/ajax/select2Indikator',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
            return {
            results:  $.map(data, function (item) {
                return {
                text: item.nama_indikator,
                id: item.id
                }
            })
            };
        },
        cache: true
        }
    });
});

function hapus_indikator(indikator_id = null)
{
	if(indikator_id == null){
		indikator_id = $(".indikator").val();
	}

	$('.btn-hapus-indikator').prop('disabled', true)
	
	$.ajax({
		url: "/indikator-pemeriksaan-lab/"+indikator_id,
		type: "DELETE",
		data: {
			_token: $('meta[name="csrf-token"]').attr('content'),
			indikator_id: indikator_id
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
		url : "/indikator-pemeriksaan-lab/{{$tindakan->id}}",
		type : "GET",
		success : (response)=>{
			$('#table-detail-section').html(response)
            $('.editableRow').editable({
				type: 'text',
				value : '',
				url: '/ajax/indikator-editable',
				title: 'Masukan data baru'
			});
			$('.editableRow').on('save', (e, editable) => {
				refresh_table()
			})
            $('#datatable').DataTable()
		}
	})
}

function tambah_indikator() {
    let nama_indikator = $('.nama_indikator').val()
    let satuan = $('.satuan').val()
    let nilai_rujukan = $('.nilai_rujukan').val()
    let tindakan_id = '{{$tindakan->id}}'

    if(nama_indikator == '' || satuan == '' || nilai_rujukan == '')
    {
      return alert('Indikator Atau Jumlah Tidak Boleh Kosong');
    }

    $.ajax({
        url: "/indikator-pemeriksaan-lab",
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            nama_indikator : nama_indikator,
            satuan : satuan,
            nilai_rujukan : nilai_rujukan,        
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
    <link href="{{asset('bootstrap3-editable/css/bootstrap-editable.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
@endpush