@extends('layouts.app')
@section('title','Kelola Data Akun')
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Kelola Data Pegawai
      <small>Daftar Pegawai</small>
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
            <a href="{{route('pegawai.create')}}" class="btn btn-info btn-social btn-flat"><i class="fa fa-plus-square-o" aria-hidden="true"></i>
              Tambah Data</a>
            <hr>
            @include('alert')
            <table class="table table-bordered table-striped" id="pegawai-table">
              <thead>
                <tr>
                  <th width="10">Nomor</th>
                  <th>Nama</th>
                  <th>Tempat Lahir</th>
                  <th>Tanggal Lahir</th>
                  <th>Kelompok Pegawai</th>
                  <th>Agama</th>
                  <th>Jenis Kelamin</th>
                  <th>Alamat</th>
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
    $('#pegawai-table').DataTable({
      processing: true,
      serverSide: true,
      ajax: '/pegawai',
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
          data: 'nip',
          name: 'nip'
        },
        {
          data: 'tempat_lahir',
          name: 'tempat_lahir'
        },
        {
          data: 'kelompok_pegawai',
          name: 'kelompok_pegawai'
        },
        {
          data: 'agama.agama',
          name: 'agama.agama'
        },
        {
          data: 'jenis_kelamin',
          name: 'jenis_kelamin'
        },
        {
          data: 'alamat',
          name: 'alamat'
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