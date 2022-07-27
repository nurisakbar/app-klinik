@extends('layouts.app')
@section('title','Kelola Permintaan Barang Internal')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Kelola Permintaan Barang Internal
        <small>Daftar Permintaan Barang Internal</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Permintaan Barang Internal</li>
      </ol>
    </section>


    <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-body">
                <a href="{{route('permintaan-barang-internal.create')}}" class="btn btn-info btn-social btn-flat"><i class="fa fa-plus-square-o" aria-hidden="true"></i>
                  Form Permintaan Barang Internal</a>
                <hr>
                @include('alert')
                <table class="table table-bordered table-striped" id="permintaan-barang-internal-table">
                  <thead>
                      <tr>
                        <th width="10">Nomor</th>
                        <th>Permintaan Dari Unit</th>
                        <th>Ke Unit</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th width="100">#</th>
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
        $('#permintaan-barang-internal-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/permintaan-barang-internal',
            columns: [
                { data: 'DT_RowIndex', orderable: false, searchable: false},
                { data: 'unit_stock_id_sumber', name: 'unit_stock_id_sumber' },
                { data: 'unit_stock_id_tujuan', name: 'unit_stock_id_tujuan' },
                { data: 'tanggal', name: 'tanggal' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action' }
            ]
        });
    });
</script>
@endpush

@push('css')
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
@endpush
