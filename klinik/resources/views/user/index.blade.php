@extends('layouts.app')
@section('title','Kelola Pengguna')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Kelola Pengguna
        <small>Daftar Pengguna</small>
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
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th width="100">Action</th>
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
            ajax: '/user?role=user',
            columns: [
                {data: 'DT_RowIndex', orderable: false, searchable: false},
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'role', name: 'role' },
                { data: 'action', name: 'action' }
            ]
        });
    });
</script>
@endpush

@push('css')
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
@endpush
