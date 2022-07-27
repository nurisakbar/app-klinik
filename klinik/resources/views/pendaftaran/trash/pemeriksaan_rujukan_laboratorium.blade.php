@extends('layouts.app')
@section('title','Kelola Data Pasien Rujukan')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Kelola Data Pasien
            <small>Pasien rujukan Laboratorium</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Rujukan Laboratorium</li>
        </ol>
    </section>

    @include('pendaftaran._informasi_umum')

    <section class="content" style="margin-top: -30px;">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    

                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                @include('pendaftaran._tab')
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Buat Rujukan Laboratorium</h4>
                                <hr>
                                <table class="table table-bordered table-bordered">
                                    <tr>
                                        <th colspan="2">FORM INPUT RUJUKAN LABORATORIUM</th>
                                    </tr>
                                    <tr>
                                        <td>Pilih Poliklinik</td>
                                        <td>
                                            <select name="poliklinik_id" id="poliklinik_id" class='select2 form-control' style="width:100%">
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Pilih Dokter Perujuk</td>
                                        <td>
                                            <select name="users_id" id="users_id" class='select2 form-control' style="width:100%">
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Pilih Tindakan Laboratorium</td>
                                        <td>
                                            <select name="tindakan_id" id="tindakan_id" class='select2 form-control' style="width:100%">
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                                            <div class="btn btn-primary add-item pull-right" onClick="addRujukan(this)"
                                                data-jenis='rujukan'>
                                                <i class="fa fa-new"></i>
                                                Buat Rujukan
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
</section>


@endsection

@push('css')
<link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
<link href="{{asset('/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
@endpush


@push('scripts')
<!-- DataTables -->
<script src="{{asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('adminlte/bower_components/select2/dist/js/select2.min.js')}}"></script>
<script src="{{asset('datatables/datatables.min.js') }}"></script>
<script>
    getRujukan()
    $('#users_id').select2({
        placeholder: 'Cari Dokter',
        multiple: false,
        ajax: {
            url: '/ajax/select2Dokter',
            dataType: 'json',
            delay: 250,
            multiple: false,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });
    
    $('#tindakan_id').select2({
        placeholder: 'Cari Tindakan Lab',
        multiple: false,
        ajax: {
            url: '/ajax/select2TindakanLaboratorium',
            dataType: 'json',
            delay: 250,
            multiple: false,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.nama_jenis,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });
    
    $('#poliklinik_id').select2({
        placeholder: 'Cari Poliklinik',
        multiple: false,
        ajax: {
            url: '/ajax/select2Poliklinik',
            dataType: 'json',
            delay: 250,
            multiple: false,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.nama,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });
    
    function getRujukan() {
        $('#rujukan-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
				url : '{{ route("resume.rujukanLab") }}',
				data : {
					id : '{{$pendaftaran->pasien_id}}'
				}
			},
            columns: [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'tindakan',
                    name: 'tindakan'
                },
                {
                    data: 'dokter',
                    name: 'dokter'
                }
            ]
        });
    }
	
	function addRujukan(btn) {
        let poliklinik = $('#poliklinik_id').select2('data')[0].id;
        let tindakan = $('#tindakan_id').select2('data')[0].id;
        let dokter = $('#users_id').select2('data')[0].id;
        let pasien_id = '{{$pendaftaran->pasien_id}}';
        let pendaftaran_id = '{{$pendaftaran->id}}';

        $.ajax({
            url : '/rujukan-lab-add-item',
            method : 'POST',
            data : {
				_token : '{{csrf_token()}}',
                poliklinik_id : poliklinik,
                tindakan_id : tindakan,
                users_id : dokter,
                pasien_id : pasien_id,
                pendaftaran_id : pendaftaran_id
            },
            success : (response)=>{
                $('#table-rujukan').html(response)
				getRujukan()
                window.location.replace('/pendaftaran')
            }
        })
	}

	function removeRujukan(btn) {
        let id = btn.getAttribute('data-id')
        $.ajax({
            url :'/rujukan-lab-remove-item/'+id,
            method : 'DELETE',
            data : {
                _token : '{{csrf_token()}}'
            },
            success : (response)=>{
                $('#table-rujukan').html(response)
				getRujukan()
            }
        })
    }
</script>

@endpush