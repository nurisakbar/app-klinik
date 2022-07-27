@extends('layouts.app')
@section('title','Kelola Data Barang')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Kelola Data Barang
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
                <a href="{{route('barang.create')}}" class="btn btn-info btn-social btn-flat"><i class="fa fa-plus-square-o" aria-hidden="true"></i>
                  Tambah Barang</a>
                  <a href="{{route('barang.export_excel')}}" class="btn btn btn-success btn-social btn-flat"><i class="fa fa-file-excel-o" aria-hidden="true"></i>
                    Export Excel
                  </a>
                  <button type="button" class="btn btn-primary btn-social btn-flat" data-toggle="modal" data-target="#myModal">
                    <i class="fa fa-file-excel-o" aria-hidden="true"></i> Import Data
                  </button>

                  <hr>
                @include('alert')
                <table class="table table-bordered table-striped" id="users-table">
                  <thead>
                      <tr>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Satuan Terbesar</th>
                        <th>Satuan Terkecil</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Harga + PPN</th>
                        <th>Harga Jual</th>
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
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Import Data Barang</h4>
      </div>
      {{ Form::open(['url'=>'barang/import','files'=>true]) }}
      <div class="modal-body">

        <div class="alert alert-info" role="alert">Download Template Import <a href="{{ asset('template_import_barang.xlsx')}}">Disini</a></div>
       <table class="table table-bordered">
         <tr>
           <td>Pilih FIle</td>
           <td>
             {{ Form::file('file')}}
           </td>
         </tr>
         <tr>
          <td>Kosongkan Data Sebelumnya ?</td>
          <td>
            <select name="kosongkan" class="form-control">
              <option value="0">Tidak</option>
              <option value="1">Ya</option>
            </select>
          </td>
        </tr>
       </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Upload</button>
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
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/barang',
            columns: [
                { data: 'kode', name: 'kode' },
                { data: 'nama_barang', name: 'nama_barang' },
                { data: 'satuan_terbesar', name: 'satuan_terbesar' },
                { data: 'satuan_terkecil', name: 'satuan_terkecil' },
                { data: 'kategori.nama_kategori', name: 'kategori.nama_kategori' },
                { data: 'harga', name: 'harga' },
                { data: 'harga_ppn', name: 'harga_ppn' },
                { data: 'harga_jual', name: 'harga_jual' },
                { data: 'action', name: 'action' }
            ]
        });
    });
</script>
@endpush

@push('css')
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
@endpush
