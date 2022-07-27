@extends('layouts.app')
@section('title','Kelola Data Pasien Diagnosa')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Kelola Data Pasien
            <small>Pasien diagnosa</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
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
                            <div class="col-md-6">
                                <h4>Form Input Diagnosa</h4>
                                <hr>
                                <table class="table table-bordered table-bordered">
                                    <tr>
                                        <th colspan="2">FORM INPUT DIAGNOSA</th>
                                    </tr>
                                    <tr>
                                        <td>Pilih Diagnosa</td>
                                        <td>
                                            <select name="diagnosa_id" id="diagnosa_id" class='select2 form-control'>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                                            <div class="btn btn-primary add-item" onClick="addDiagnosa(this)"
                                                data-jenis='diagnosa'>
                                                <i class="fa fa-plus"></i>
                                                Tambah
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h4>Daftar Diagnosa</h4>
                                <hr>
                                <div id="table-diagnosa">
                                    <table class="table table-bordered table-striped" width="100%"
                                    id="diagnosa-table">
                                        <thead>
                                            <tr>
                                                <th width="10">Nomor</th>
                                                <th width="10">Kode</th>
                                                <th>Nama Diagnosa</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
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
    getDiagnosa()
    $('#diagnosa_id').select2({
        placeholder: 'Cari Riwayat Penyakit',
        multiple: false,
        ajax: {
            url: '/ajax/select2ICD',
            dataType: 'json',
            delay: 250,
            multiple: false,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.indonesia,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });

    function getDiagnosa() {
        $('#diagnosa-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
				url : '{{ route("resume.diagnosaICD") }}',
				data : {
					id : '{{$pendaftaran->id}}'
				}
			},
            columns: [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'kode',
                    name: 'kode'
                },
                {
                    data: 'tbm_icd',
                    name: 'tbm_icd'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        });
    }

	function addDiagnosa(btn) {
        let diagnosa = $('#diagnosa_id').select2('data')[0].id;
        $.ajax({
            url : '/diagnosa-add-item/{{$pendaftaran->id}}',
            method : 'POST',
            data : {
				_token : '{{csrf_token()}}',
                tbm_icd_id : diagnosa,
            },
            success : (response)=>{
                $('#table-diagnosa').html(response)
				getDiagnosa()
            }
        })
	}

	function removeDiagnosa(btn) {
        let id = btn.getAttribute('data-id')
        $.ajax({
            url :'/diagnosa-remove-item/'+id,
            method : 'DELETE',
            data : {
                _token : '{{csrf_token()}}'
            },
            success : (response)=>{
                $('#table-diagnosa').html(response)
				getDiagnosa()
            }
        })
    }
</script>

@endpush
