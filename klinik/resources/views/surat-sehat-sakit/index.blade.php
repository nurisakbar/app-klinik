@extends('layouts.app')
@section('title','Kelola Data Surat Sehat Dan Sakit')
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Kelola Data Surat Sehat Dan Sakit
      <small>Daftar Surat Sehat Dan Sakit</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>


  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">

          <div class="box-body">
            <a href="{{ url('surat-sehat-sakit/surat-sehat') }}" class="btn btn-info btn-social btn-flat"><i class="fa fa-plus-square-o" aria-hidden="true"></i>
              Tambah Surat Sehat</a>
            <a href="{{ url('surat-sehat-sakit/surat-sakit') }}" class="btn btn-info btn-social btn-flat"><i class="fa fa-plus-square-o" aria-hidden="true"></i>
              Tambah Surat Sakit</a>
            <hr>
            @include('alert')
            <table class="table table-bordered table-striped" id="surat-table">
              <thead>
                <tr>
                  <th width="10">Nomor</th>
                  <th>Tanggal</th>
                  <th>Nama Pasien</th>
                  <th>Nama Dokter</th>
                  <th>Tipe Surat</th>
                  <th width="60">#</th>
                </tr>
              </thead>
            </table>
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
<script>
  $(function() {
    $('#surat-table').DataTable({
      processing: true,
      serverSide: true,
      ajax: '/surat-sehat-sakit',
      columns: [{
          data: 'DT_RowIndex',
          orderable: false,
          searchable: false
        },
        {
          data: 'tanggal_mulai',
          name: 'tanggal_mulai'
        },
        {
          data: 'pasien.nama',
          name: 'pasien.nama'
        },
        {
          data: 'user.name',
          name: 'user.name'
        },
        {
          data: 'tipe_surat',
          name: 'tipe_surat'
        },
        {
          data: 'action',
          name: 'action'
        }
      ]
    });
  });
</script>
@endpush

@push('css')
<link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
@endpush