@extends('layouts.app')
@section('title','Verifikasi permintaan barang internal')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Verifikasi Permintaan Barang Internal
            <small>Verifikasi Permintaan Barang Internal</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/permintaan-barang-internal">Permintaan Barang Internal </a></li>
            <li class="active">Verifikasi barang internal</li>
        </ol>
    </section>


    <section class="content">
        @include('alert')
        <div class="row">
            <div class="col-md-5">
                <div class="box">
                    <div class="box-header text-center" style="border-bottom: 1px solid;padding-top: 0;">
                        <h3>Permintaan Barang Internal</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Tanggal Pengajuan</label>
                                    {{ Form::date('tanggal',$permintaan_barang->tanggal,['class' => 'form-control', 'disabled']) }}
                                </div>
                                <div class="form-group">
                                    <label>Unit Sumber</label>
                                    <input type="text" class="form-control" disabled
                                        value="{{$permintaan_barang->unitSumber->nama_unit}}">
                                </div>
                                <div class="form-group">
                                    <label>Unit Tujuan</label>
                                    <input type="text" class="form-control" disabled
                                        value="{{$permintaan_barang->unitTujuan->nama_unit}}">
                                </div>
                                <div class="form-group">
                                    <label>Status</label>
                                    <input type="text" class="form-control" disabled
                                        value="{{$permintaan_barang->status}}">
                                </div>
                                @if($permintaan_barang->status != 'Selesai')
                                    <div class="form-group">
                                        {{ Form::open(['route'=>['permintaan-barang-internal.verify', $permintaan_barang->id], 'method' => 'POST']) }}
                                            <button class="btn btn-success"> <i class="fa fa-check"></i> Selesai</button>
                                        {{ Form::close() }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-7">
                <div class="box">
                    <div class="box-header text-center" style="border-bottom: 1px solid;padding-top: 0;">
                        <h3>Detail Permintaan Barang Internal</h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive" id="table-detail-section">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Kode Barang</th>
                                        <th scope="col">Nama Barang</th>
                                        <th scope="col">Jumlah Diminta</th>
                                        <th scope="col">Jumlah Diterima</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $jumlah_diminta=0;$jumlah_diterima=0 @endphp
                                    @forelse($permintaan_barang->detail as $row)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$row->barang->kode}}</td>
                                            <td>{{$row->barang->nama_barang}}</td>
                                            <td style="text-align:right">{{$row->jumlah_diminta}}</td>
                                            <td style="text-align:right">
                                               <a href="#" class="editableRow" data-pk = '{{$row->id}}' data-name = 'jumlah_diterima' '>
                                                   {{$row->jumlah_diterima ? $row->jumlah_diterima : 'Masukan jumlah diterima'}}
                                               </a> 
                                            </td>
                                        </tr>
                                        @php
                                            $jumlah_diminta+=$row->jumlah_diminta;
                                            $jumlah_diterima+=$row->jumlah_diterima;
                                        @endphp
                                    @empty
                                    <tr>
                                        <td colspan=6 style="text-align:center">Data kosong</td>
                                    </tr>
                                    @endforelse
                                    <tr>
                                        <td style="text-align:right" colspan="3">Total</td>
                                        <td style="text-align:right"> {{$jumlah_diminta}} </td>
                                        <td style="text-align:right" class='total-diterima'> {{$jumlah_diterima}} </td>
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
<script src="{{asset('adminlte/bower_components/select2/dist/js/select2.min.js')}}"></script>
<script src="{{asset('bootstrap3-editable/js/bootstrap-editable.js')}}"></script>
<script>
$( document ).ready(function() {
    @if($permintaan_barang->status != 'Selesai')
        $.fn.editable.defaults.mode = 'inline'
        $('.editableRow').editable({
            type: 'text',
            value : '',
            url: '/ajax/permintaan-barang-detail-editable',
            title: 'Jumlah diterima'
        });
        $('.editableRow').on('save', (e, editable) => {
            let total = $('.total-diterima').html()
            let oldValue = editable.response.oldValue
            if(oldValue == null){
                oldValue = 0
            }
            total = parseInt(total) - parseInt(oldValue) + parseInt(editable.newValue)
            $('.total-diterima').html(total)
        })
    @endif
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
		url: "/permintaan-barang-detail/"+barang_id,
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
		url : "/permintaan-barang-detail/show",
		type : "GET",
		success : (response)=>{
			$('#table-detail-section').html(response)
		}
	})
}

function tambah_barang() {

    var barang_id = $(".barang").val();
    var qty = $(".qty").val();
    if(barang_id == '' || qty == '')
    {
      return alert('Barang Atau Jumlah Tidak Boleh Kosong');
    }

    $.ajax({
        url: "/permintaan-barang-detail",
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            barang_id: barang_id,
            jumlah_diminta: qty
        },
        success: function (response) {
            refresh_table(response)
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
    <link href="{{asset('adminlte/bower_components/select2/dist/css/select2.min.css')}}" rel="stylesheet"/>
    <style>
        .dataTables_scrollHeadInner {
            width: 100% !important;
        }

        table.dataTable {
            width: 100% !important;
        }
    </style>
@endpush