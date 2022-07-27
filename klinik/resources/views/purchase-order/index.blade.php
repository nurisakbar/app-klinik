@extends('layouts.app')
@section('title','Kelola Purchase Order')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Kelola Purchase Order
        <small>Daftar Purchase Order</small>
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
                @if(in_array(\Auth::user()->role,['bagian_gudang','admin']))
                  <a href="{{route('purchase-order.create')}}" class="btn btn-info btn-social btn-flat"><i class="fa fa-plus-square-o" aria-hidden="true"></i>
                    Form Purchase Order</a>
                  <hr>
                @endif
                @include('alert')
                <table class="table table-bordered table-striped" id="purchase-order-table">
                  <thead>
                      <tr>
                        <th width="10">Nomor</th>
                        <th>Kode Purchase Order</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Supplier</th>
                        <th>Status Purchase Order</th>
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
        $('#purchase-order-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/purchase-order',
            columns: [
                {data: 'DT_RowIndex', orderable: false, searchable: false},
                { data: 'kode', name: 'kode' },
                { data: 'tanggal', name: 'tanggal' },
                { data: 'supplier.nama_supplier', name: 'supplier.nama_supplier' },
                { data: 'status_po', name: 'status_po' },
                { data: 'action', name: 'action' }
            ]
        });
    });
</script>
@endpush

@push('css')
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
@endpush
