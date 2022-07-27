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
                                <h4>Form Input Tindakan</h4>
                                <hr>
                                <table class="table table-bordered table-bordered">
                                    <tr>
                                        <th colspan="2">FORM INPUT TINDAKAN</th>
                                    </tr>
                                    <tr>
                                        <td>Pilih Tindakan</td>
                                        <td>
                                            <select name="tindakan_id" id="tindakan_id" class='select2 form-control'>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Dokter</td>
                                        <td>
                                            {!! Form::select('dokter', $dokter, null, ['class'=>'form-control', 'id' => 'dokter']) !!}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Asistensi</td>
                                        <td>
                                            {!! Form::select('asisten', $dokter, null, ['class'=>'form-control', 'id' => 'asisten']) !!}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                                            <div class="btn btn-primary add-item" onClick="addItem(this)"
                                                data-jenis='tindakan'>
                                                <i class="fa fa-plus"></i>
                                                Tambah
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h4>Daftar Tindakan</h4>
                                <hr>
                                <div id="table-tindakan">
                                    <table class="table table-bordered table-striped" width="100%"
                                        id="tindakan-resume-table">
                                        <thead>
                                            <tr>
                                                <th width="10">Nomor</th>
                                                <th>Kode ICD 9</th>
                                                <th>Nama Tindakan</th>
                                                <th>Fee</th>
                                                <th width="70">#</th>
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

@include('pendaftaran._modal')
@include('loading')
@endsection

@push('scripts')
<!-- DataTables -->
<script src="{{asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('adminlte/bower_components/select2/dist/js/select2.min.js')}}"></script>
<script src="{{asset('datatables/datatables.min.js') }}"></script>
<script>
    function addItem(btn){
        let tindakan_id = $('#tindakan_id').select2('data')[0].id
        let dokter = $('#dokter').find(":selected").val();
        let asisten = $('#asisten').find(":selected").val();
        $.ajax({
            url : '/tindakan-add-item',
            method : 'GET',
            data : {
                tindakan_id : tindakan_id,
                dokter : dokter,
                asisten : asisten,
                pendaftaran_id : '{{$pendaftaran->id}}'
            },
            success : (response)=>{
                $('#table-tindakan').html(response)
                getResumeTindakan()
            }
        })
    }

    function removeItem(btn) {
        let id = btn.getAttribute('data-id')
        $.ajax({
            url :'/resume/tindakan/'+id,
            method : 'DELETE',
            data : {
                _token : '{{csrf_token()}}'
            },
            success : (response)=>{
                $('#table-tindakan').html(response)
                getResumeTindakan()
            }
        })
    }

    function getResumeTindakan() {
        $('#tindakan-resume-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url : '{{ route("resume.tindakan") }}',
                data : {
                    pendaftaran_id : '{{$pendaftaran->id}}'
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
                    data: 'tindakan.tindakan',
                    name: 'tindakan.tindakan'
                },
                {
                    data: 'fee',
                    name: 'fee'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        });
    }

    $(function () {
        getResumeTindakan()

        $('#tindakan_id').select2({
            placeholder: 'Cari tindakan',
            multiple : false,
            ajax: {
                url: '/ajax/select2Tindakan',
                dataType: 'json',
                delay: 250,
                multiple: false,
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.kode + ' - ' + item.tindakan,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });
    });
</script>
@endpush

@push('css')
<link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
<link href="{{asset('/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
@endpush
