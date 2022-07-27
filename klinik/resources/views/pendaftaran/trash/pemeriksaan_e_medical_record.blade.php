@extends('layouts.app')
@section('title','Kelola Data Pasien E Medical Record')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Kelola Data Pasien
            <small>Pasien E Medical Record</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Data Pasien E Medical Record</li>
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
                                <h4>Informasi Riwayat Diagnosa</h4>
                                <hr>
                                <div id="table-diagnosa">
                                    <table class="table table-bordered table-striped" width="100%" id="diagnosa-table">
                                        <thead>
                                            <tr>
                                                <th width="10">Nomor</th>
                                                <th>TBM ICD</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h4>Informasi Riwayat Rawat Jalan</h4>
                                <hr>
                                <div id="table-rawat-jalan">
                                    <table class="table table-bordered table-striped" width="100%" id="rawat-jalan-table">
                                        <thead>
                                            <tr>
                                                <th width="10">Nomor</th>
                                                <th>Tanggal</th>
                                                <th>Penjamin</th>
                                                <th>Poliklinik</th>
                                                <th>Dokter</th>
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
    </section>
</div>


@endsection

@push('css')
<link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
@endpush


@push('scripts')
<!-- DataTables -->
<script src="{{asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('datatables/datatables.min.js') }}"></script>
<script>
    $(function() {
        $('#diagnosa-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
				url : '/resume/diagnosa',
				data : {
					id : '{{$pendaftaran->id}}',
                    jenis : 'diagnosa'
				}
			},
            columns: [
                {
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'icd.indonesia',
                    name: 'icd.indonesia'
                },
            ]
        });
        $('#rawat-jalan-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
				url : '/resume/rawat-jalan',
				data : {
					id : '{{$pendaftaran->id}}',
                    jenis : 'rawat-jalan'
				}
			},
            columns: [
                {
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'perusahaan_asuransi.nama_perusahaan',
                    name: 'perusahaan_asuransi.nama_perusahaan'
                },
                {
                    data: 'poliklinik.nama',
                    name: 'poliklinik.nama'
                },
                {
                    data: 'dokter.name',
                    name: 'dokter.name'
                },
            ]
        });
    });
</script>

@endpush