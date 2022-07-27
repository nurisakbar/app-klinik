@extends('layouts.app')
@section('title','Laporan Barang Keluar')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Laporan Barang Keluar
        <small>Laporan Barang Keluar</small>
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
                      {!! Form::open(['url'=>'laporan-barang-keluar','method'=>'GET']) !!}
                      <table class="table table-bordered">
                          <tr>
                              <td width="200">Tanggal Mulai</td>
                              <td>
                                  <div class="row">
                                      <div class="col-md-2">
                                        {!! Form::date('tanggal_awal', $tanggal_awal, ['class'=>'form-control tanggal_awal','placeholder'=>'Tanggal Mulai']) !!}
                                      </div>
                                      <div class="col-md-2">
                                        {!! Form::date('tanggal_akhir', $tanggal_akhir, ['class'=>'form-control tanggal_akhir','placeholder'=>'Tanggal Mulai']) !!}
                                      </div>
                                      <div class="col-md-3">
                                        {!! Form::select('perusahaan_penjamin_id', $perusahaan_asuransi,$perusahaan_penjamin_id, ['class'=>'form-control perusahaan_penjamin_id']) !!}
                                      </div>
                                      <div class="col-md-4">
                                          <button type="submit" name="type" value="web" class="btn btn-danger"><i class="fa fa-cogs" aria-hidden="true"></i>
                                             Filter Laporan</button>
                                          <button type="submit" name="type" value="excel" class="btn btn-success" style="float:right"><i class="fa fa-file-excel-o" aria-hidden="true"></i>
                                             Download Excel</button>
                                      </div>
                                  </div>
                              </td>
                          </tr>
                      </table>
                      {!! Form::close() !!}
                      <hr>
                      <table class="table table-bordered" id="laporan-barang">
                          <thead>
                              <tr>
                                  <th width="10">Nomor</th>
                                  <th width="100">Kode Barang</th>
                                  <th>Nama Barang</th>
                                  <th width="100">Jumlah Terjual</th>
                                  <th>Total Modal</th>
                                  <th>Total Jual</th>
                                  <th>Untung</th>
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
    $(document).ready( function () {
        var tanggal_awal = $(".tanggal_awal").val();
        var tanggal_akhir = $(".tanggal_akhir").val();
        var perusahaan_penjamin_id = $(".perusahaan_penjamin_id").val();
        console.log(tanggal_awal);
        $('#laporan-barang').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/laporan-barang-keluar?tanggal_awal='+tanggal_awal+"&tanggal_akhir="+tanggal_akhir+"&perusahaan_penjamin_id="+perusahaan_penjamin_id,
        columns: 
        [
            {
            data: 'DT_RowIndex',
            orderable: false,
            searchable: false
            },
            {
            data: 'kode',
            name: 'kode'
            },
            {
            data: 'nama_barang',
            name: 'nama_barang'
            },
            {
            data: 'jumlah_terjual',
            name: 'jumlah_terjual'
            }
            ,
            {
            data: 'total_modal',
            name: 'total_modal'
            },
            {
            data: 'total_jual',
            name: 'total_jual'
            },
            {
            data: 'untung',
            name: 'untung'
            }
        ]
        });
} );
</script>
@endpush

@push('css')
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
@endpush

