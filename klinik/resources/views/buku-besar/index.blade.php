@extends('layouts.app')
@section('title','Buku Besar')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Kelola Data Buku Besar
        <small>Daftar Buku Besar</small>
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
                @include('alert')
                <table class="table table-bordered table-striped text-center" id="akun-table">
                  <thead>
                      <tr>
                        <th width="10">Nomor</th>
                        <th>Daftar Akun</th>
                        <th>#</th>
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
        $('#akun-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/buku-besar',
            columns: [
                {data: 'DT_RowIndex', orderable: false, searchable: false},
                { data: 'nama', name: 'nama' },
                { data: 'action', name: 'action' }
            ]
        });
    });
</script>
@endpush

@push('css')
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
@endpush
