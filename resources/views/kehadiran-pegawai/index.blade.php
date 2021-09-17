@extends('layouts.app')
@section('title','Kelola Data Kehadiran Pegawai')
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Kelola Data Kehadiran Pegawai
      <small>Daftar Kehadiran Pegawai</small>
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
            <a href="{{route('kehadiran-pegawai.create')}}" class="btn btn-info btn-social btn-flat mr-3" style="margin-right: 10px"><i class="fa fa-plus-square-o" aria-hidden="true"></i>
              Tambah Data</a>
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                Export Excel
              </button>
            <hr>
            @include('alert')
            <table class="table table-bordered table-striped" id="pegawai-table">
              <thead>
                <tr>
                  <th width="10">Nomor</th>
                  <th>Nama</th>
                  <th>Jam Masuk</th>
                  <th>Jam Keluar</th>
                  <th>Tanggal</th>
                  <th>Status</th>
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
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {{ Form::open(['route' => 'kehadiran-pegawai.export_excel']) }}
        <table class="table table-bordered">
          <tr>
            <th>Tanggal Mulai</th>
            <td><input type="date" name="tanggal_mulai" class="form-control"></td>
          </tr>
          <tr>
            <th>Tanggal Selesai</th>
            <td><input type="date" name="tanggal_selesai" class="form-control"></td>
          </tr>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      {{ Form::close() }}
    </div>
  </div>
</div>
@endsection

@push('scripts')
<!-- DataTables -->
<script src="{{asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script>
  
  $(function() {
    $('#pegawai-table').DataTable({
      processing: true,
      serverSide: true,
      ajax: '/kehadiran-pegawai',
      columns: [{
          data: 'DT_RowIndex',
          orderable: false,
          searchable: false
        },
        {
          data: 'nama',
          name: 'nama'
        },
        {
          data: 'jam_masuk',
          name: 'jam_masuk'
        },
        {
          data: 'jam_keluar',
          name: 'jam_keluar'
        },
        {
          data: 'tanggal',
          name: 'tanggal'
        },
        {
          data: 'status',
          name: 'status'
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