@extends('layouts.app')
@section('title','Laporan Kunjungan Pasien Per Poliklinik')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Laporan Kunjungan Pasien Per Poliklinik
        <small>Setting Aplikasi</small>
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
                      {!! Form::open(['url'=>'laporan/kunjungan-perpoli','method'=>'GET']) !!}
                      <table class="table table-bordered">
                          <tr>
                              <td width="200">Tanggal Mulai</td>
                              <td>
                                  <div class="row">
                                      <div class="col-md-2">
                                        {!! Form::date('tanggal_awal', $tanggal_awal, ['class'=>'form-control','placeholder'=>'Tanggal Mulai']) !!}
                                      </div>
                                      <div class="col-md-2">
                                        {!! Form::date('tanggal_akhir', $tanggal_akhir, ['class'=>'form-control','placeholder'=>'Tanggal Mulai']) !!}
                                      </div>
                                      <div class="col-md-3">
                                        {!! Form::select('perusahaan_penjamin_id', $perusahaan_asuransi,$perusahaan_penjamin_id, ['class'=>'form-control perusahaan_penjamin_id','placeholder'=>'Semua Penjamin']) !!}
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
                      <table class="table table-bordered" id="myTable">
                          <thead>
                              <tr>
                                  <th width="100">Nomor Poli</th>
                                  <th>Nama Poli</th>
                                  <th width="150">Jumlah Kunjungan</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach($laporan as $poli)
                              <tr>
                                  <td>{{ $poli->nomor_poli }}</td>
                                  <td>{{ $poli->nama}}</td>
                                  <td>{{ $poli->jumlah_kunjungan}}</td>
                              </tr>
                              @endforeach
                          </tbody>
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
    $('#myTable').DataTable();
} );
</script>
@endpush

@push('css')
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
@endpush

