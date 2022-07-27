@extends('layouts.app')
@section('title','Kelola Stock Barang')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Kelola Stock Barang {{ $unit_stock->nama_unit}}
        <small>Daftar Barang</small>
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
               

                  <button type="button" class="btn btn-primary btn-social btn-flat" data-toggle="modal" data-target="#myModal">
                    <i class="fa fa-file-excel-o" aria-hidden="true"></i> Stock Opname {{ $unit_stock->nama_unit}}
                  </button>
                  <a href="/unit-stock/sinkronisasi/{{ $unit_stock->id}}" class="btn btn-info btn-social btn-flat">Sinkronisasi Data</a>

                  <hr>
                @include('alert')
                <input type="hidden" id="unit_stock_id" value="{{$unit_stock_id}}">
                <table class="table table-bordered table-striped" id="users-table">
                  <thead>
                      <tr>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Satuan Terbesar</th>
                        <th>Satuan Terkecil</th>
                        <th>Kategori</th>
                        <th>Sisa Stock</th>
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
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    {{ Form::open(['url'=>'stock-opname-unit','files'=>true]) }}
    {{ Form::hidden('unit_stock_id',$unit_stock_id) }}
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Stock Opname {{ $unit_stock->nama_unit}}</h4>
      </div>
      <div class="modal-body">
        <div class="alert alert-success" role="alert">Download Template Import Barang <a href="/stock/{{$unit_stock_id}}?type=excel"><b>Disini</b></a></div>
        <table class="table table-bordered">
          <tr>
            <td>Pilih File</td>
            <td><input type="file" name="file" accept=".xlsx"></td>
          </tr>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Upload & Proses</button>
      </div>
    </div>
    {{ Form::close() }}
  </div>
</div>

@endsection

@push('scripts')
<!-- DataTables -->
<script src="{{asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script>
    $(function() {
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/stock?unit_stock_id='+$("#unit_stock_id").val(),
            order: [[5, 'asc']],
            columns: [
                { data: 'kode', name: 'kode' },
                { data: 'nama_barang', name: 'nama_barang' },
                { data: 'satuan_terbesar', name: 'satuan_terbesar' },
                { data: 'satuan_terkecil', name: 'satuan_terkecil' },
                { data: 'nama_kategori', name: 'nama_kategori' },
                { data: 'jumlah_stock', name: 'jumlah_stock' }
            ]
        });
    });
</script>
@endpush

@push('css')
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
@endpush
