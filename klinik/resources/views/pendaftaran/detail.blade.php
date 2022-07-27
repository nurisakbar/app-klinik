@extends('layouts.app')
@section('title','Kelola Data Pasien Diagnosa')
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
        Kelola Data Pasien
        <small>Pasien diagnosa</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box card-height">
                    <div class="box-header card-header">
                        <strong>Informasi Pasien</strong>
                        
                    </div>
                    <div class="box-body">
                      <div class="row">

                        <div class="card-spac">
                            <div class="col-md-5">
                                <strong>Nomor Pendaftaran</strong>
                            </div>
                            <div class="col-md-7">
                                : {{ $pasien->kode }}
                            </div>
                        </div>

                        <div class="card-spac">
                            <div class="col-md-5">
                                <strong>Nama</strong>
                            </div>
                            <div class="col-md-7">
                                : {{ $pasien->pasien->nama }}
                            </div>
                        </div>

                        <div class="card-spac">
                            <div class="col-md-5">
                                <strong>Tempat tgl lahir</strong>
                            </div>
                            <div class="col-md-7">
                                : {{ $pasien->pasien->tempat_lahir }}, {{ tgl_indo($pasien->pasien->tanggal_lahir) }}
                            </div>
                        </div>

                        <div class="card-spac">
                            <div class="col-md-5">
                                <strong>Umur</strong>
                            </div>
                            <div class="col-md-7">
                                : {{ hitung_umur($pasien->pasien->tanggal_lahir) }} tahun
                            </div>
                        </div>

                      </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="box card-height">
                    <div class="box-header card-header">
                        <strong>Informasi Terkait</strong>
                        
                    </div>
                    <div class="box-body">
                      <div class="row">

                        <div class="card-spac">
                            <div class="col-md-5">
                                <strong>Tujuan Poliklinik</strong>
                            </div>
                            <div class="col-md-7">
                                : {{ $pasien->poliklinik->nama }}
                            </div>
                        </div>

                        <div class="card-spac">
                            <div class="col-md-5">
                                <strong>Tanggal Sekarang</strong>
                            </div>
                            <div class="col-md-7">
                                : {{ tgl_indo(date('Y-m-d')) }}
                            </div>
                        </div>

                        <div class="card-spac">
                            <div class="col-md-5">
                                <strong>Jenis Layanan</strong>
                            </div>
                            <div class="col-md-7">
                                : {{ $pasien->jenis_layanan }}
                            </div>
                        </div>

                      </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="content" style="margin-top: -30px;">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                            <li class="nav-item active">
                                <a class="nav-link active" id="custom-tabs-two-vital-tab" data-toggle="pill" href="#custom-tabs-two-vital-tab" role="tab" aria-controls="custom-tabs-two-vital-tab" aria-selected="true">Tanda Tanda Vital</a>
                            </li>
                            <li class="nav-item active">
                                <a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill" href="#custom-tabs-two-home" role="tab" aria-controls="custom-tabs-two-home" aria-selected="false">Diagnosa</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#custom-tabs-two-profile" role="tab" aria-controls="custom-tabs-two-profile" aria-selected="false">Resep</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-two-messages-tab" data-toggle="pill" href="#custom-tabs-two-messages" role="tab" aria-controls="custom-tabs-two-messages" aria-selected="false">Tindakan</a>
                            </li>
                            <li style="float: inline-end;">
                                <button class="btn btn-success btn-sm button-select">Biling Poli Selesai</button>
                            </li>
                        </ul>
                    </div>
                    <div class="box-body"> 
                        <div class="tab-content" id="custom-tabs-two-tabContent">
                            <div class="tab-pane fade active in" id="custom-tabs-two-vital-tab" role="tabpanel" aria-labelledby="custom-tabs-two-vital-tab">
                                <div class="box">
                                    <div class="box-header card-header">
                                        <div class="row">
                                            <div class="col-md-6 text-left">
                                                Daftar diagnosa vital
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalDiagnosa">Tambah</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-body">
                                        <table class="table table-bordered table-striped" width="100%" id="diagnosa-resume-table">
                                            <thead>
                                                <tr>
                                                  <th width="10">Nomor</th>
                                                  <th>Kode</th>
                                                  <th>Nama Diagnosa</th>
                                                  <th>#</th>
                                                </tr>
                                            </thead>
                                          </table>
                                    </div>
                                </div>
                            </div>


                        <div class="tab-pane fade active in" id="custom-tabs-two-home" role="tabpanel" aria-labelledby="custom-tabs-two-home-tab">
                            <div class="box">
                                <div class="box-header card-header">
                                    <div class="row">
                                        <div class="col-md-6 text-left">
                                            Daftar diagnosa pasien
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalDiagnosa">Tambah</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <table class="table table-bordered table-striped" width="100%" id="diagnosa-resume-table">
                                        <thead>
                                            <tr>
                                              <th width="10">Nomor</th>
                                              <th>Kode</th>
                                              <th>Nama Diagnosa</th>
                                              <th>#</th>
                                            </tr>
                                        </thead>
                                      </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-two-profile" role="tabpanel" aria-labelledby="custom-tabs-two-profile-tab">
                            <div class="box">
                                <div class="box-header card-header">
                                    <div class="row">
                                        <div class="col-md-6 text-left">
                                            Daftar resep pasien
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalResep">Tambah</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <table class="table table-bordered table-striped" width="100%" id="resep-resume-table">
                                        <thead>
                                            <tr>
                                              <th width="10">Nomor</th>
                                              <th>Kode</th>
                                              <th>Nama Obat</th>
                                              <th>Jumlah</th>
                                              <th>Keterangan</th>
                                              <th>#</th>
                                            </tr>
                                        </thead>
                                      </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-two-messages" role="tabpanel" aria-labelledby="custom-tabs-two-messages-tab">
                            <div class="box">
                                <div class="box-header card-header">
                                    <div class="row">
                                        <div class="col-md-6 text-left">
                                            Daftar Tindakan Pasien
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTindakan">Tambah</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <table class="table table-bordered table-striped" width="100%" id="tindakan-resume-table">
                                        <thead>
                                            <tr>
                                              <th width="10">Nomor</th>
                                              <th>Kode</th>
                                              <th>Nama Tindakan</th>
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

  </div>

@include('pendaftaran._modal')
@include('loading')
@endsection

@push('scripts')
<!-- DataTables -->
<script src="{{asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>

<script src="{{ asset('datatables/datatables.min.js') }}"></script>
<script>
    $(function() {

        $('#diagnosa-resume-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("resume.diagnosa") }}',
            columns: [
                {data: 'DT_RowIndex', orderable: false, searchable: false},
                { data: 'diagnosa.kode', name: 'diagnosa.kode' },
                { data: 'diagnosa.nama', name: 'diagnosa.nama' },
                { data: 'action', name: 'action' }
            ]
        });

        $('#resep-resume-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("resume.resep") }}',
            columns: [
                {data: 'DT_RowIndex', orderable: false, searchable: false},
                { data: 'obat.kode', name: 'obat.kode' },
                { data: 'obat.nama_obat', name: 'obat.nama_obat' },
                { data: 'jumlah', name: 'jumlah' },
                { data: 'keterangan', name: 'keterangan' },
                { data: 'action', name: 'action' }
            ]
        });

        $('#tindakan-resume-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("resume.tindakan") }}',
            columns: [
                {data: 'DT_RowIndex', orderable: false, searchable: false},
                { data: 'tindakan.kode', name: 'tindakan.kode' },
                { data: 'tindakan.tindakan', name: 'tindakan.tindakan' },
                { data: 'action', name: 'action' }
            ]
        });

    });
</script>

<script>
    $(document).ready(function (){

        $('.pilih-diagnosa').click(function() {
            var jenis_resume_id = $(this).data('id');
            var pendaftaran_id  = "{{ $pasien->id }}";
            var jenis           = "diagnosa";
            $.ajax({
                url: '{{ route("resume.pilih-diagnosa") }}',
                method: 'POST',
                data : {
                    "_token"          : "{{ csrf_token() }}",
                    "jenis_resume_id" : jenis_resume_id,
                    "pendaftaran_id"  : pendaftaran_id,
                    "jenis"           : jenis
                },
                beforeSend: function(){
                    $("#modalDiagnosa").modal('toggle');
                    $("#modalLoading").modal('show');
                },
                success: function(response) {
                    location.reload();
                }
            });
        });

        $('.pilih-obat').click(function() {
            var id = $(this).data('id');
            $.ajax({
                url: '{{ route("resume.pilih-resep") }}',
                method: 'POST',
                data : {
                    "_token" : "{{ csrf_token() }}",
                    "id"     : id,
                },
                beforeSend: function(){
                    $("#modalResep").modal('toggle');
                    $("#modalLoading").modal('show');
                },
                success: function(response) {
                    $("#modalLoading").modal('toggle');
                    $("#modalResepNext").modal('show');
                    $(".kode-obat").text(response.kode);
                    $("#data-jenis-resume-id").val(response.id);
                }
            });
        });

        $('.tambah-obat').click(function() {
            var pendaftaran_id  = "{{ $pasien->id }}";
            var jenis_resume_id = $("#data-jenis-resume-id").val();
            var jumlah          = $("#jumlah-obat").val();
            var aturan_pakai    = $("#aturan-pakai").val();
            var jenis           = 'obat';

            if(jumlah == "" || aturan_pakai == "")
            {
                $("#modalAlert").modal('show');
            }else{

            $.ajax({
                url: '{{ route("resume.tambah-resep") }}',
                method: 'POST',
                data : {
                    "_token"          : "{{ csrf_token() }}",
                    "jenis_resume_id" : jenis_resume_id,
                    "pendaftaran_id"  : pendaftaran_id,
                    "jumlah"          : jumlah,
                    "keterangan"      : aturan_pakai,
                    "jenis"           : jenis
                },
                beforeSend: function(){
                    $("#modalResepNext").modal('toggle');
                    $("#modalLoading").modal('show');
                },
                success: function(response) {
                    location.reload();
                }
            });
        }
        });

        $('.return-pilih-obat').click(function() {
            $('#modalResep').modal('show');
            $('#modalResepNext').modal('toggle');
        });

        $('.pilih-tindakan').click(function() {
            var jenis_resume_id = $(this).data('id');
            var pendaftaran_id  = "{{ $pasien->id }}";
            var jenis           = "tindakan";
            $.ajax({
                url: '{{ route("resume.pilih-tindakan") }}',
                method: 'POST',
                data : {
                    "_token"          : "{{ csrf_token() }}",
                    "jenis_resume_id" : jenis_resume_id,
                    "pendaftaran_id"  : pendaftaran_id,
                    "jenis"           : jenis
                },
                beforeSend: function(){
                    $("#modalTindakan").modal('toggle');
                    $("#modalLoading").modal('show');
                },
                success: function(response) {
                    location.reload();
                }
            });
        });

    });

    $('#basic-datatables').DataTable({
		"scrollX": true
	});

    $('#basic-datatables-obat').DataTable({
		"scrollX": true
	});

    $('#basic-datatables-tindakan').DataTable({
		"scrollX": true
	});
</script>
@endpush

@push('css')
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
@endpush