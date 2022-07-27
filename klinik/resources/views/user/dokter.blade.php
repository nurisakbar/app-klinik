@extends('layouts.app')
@section('title','Data Dokter')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Kelola Data Dokter
        <small>Daftar Dokter</small>
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
                <a href="{{route('user.create')}}?jabatan={{$_GET['jabatan']}}" class="btn btn-info btn-social btn-flat"><i class="fa fa-plus-square-o" aria-hidden="true"></i>
                     Tambah Data</a>
                  <hr>
                @include('alert')
                <table class="table table-bordered table-striped" id="users-table">
                    <thead>
                        <tr>
                            <th width="20px">Nomor</th>
                            <th>Kode</th>
                            <th>Nama Dokter</th>
                            <th>Email</th>
                            <th>Spesialis</th>
                            <th>SIP</th>
                            <th width="90">Action</th>
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
<script src="{{asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script>
    $(function() {
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/user?role=dokter',
            columns: [
                {data: 'DT_RowIndex', orderable: false, searchable: false},
                { data: 'kode', name: 'kode' },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'spesialis', name: 'spesialis' },
                { data: 'sip', name: 'sip' },
                { data: 'action', name: 'action' }
            ]
        });
    });
</script>
@endpush

@push('css')
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
@endpush
