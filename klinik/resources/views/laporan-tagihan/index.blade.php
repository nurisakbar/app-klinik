@extends('layouts.app')
@section('title','Data Laporan Tagihan Perusahaan')
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Data Laporan Tagihan Perusahaan
      <small></small>
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
            {!! Form::open(['url'=>'laporan-tagihan','method'=>'GET']) !!}
            <table class="table table-bordered">
                <tr>
                    <td width="200">Periode</td>
                    <td>
                        <div class="row">
                          <div class="col-md-3">
                            {!! Form::month('periode', $periode, ['class'=>'form-control periode','id'=>'NoIconDemo','placeholder'=>'Tanggal Mulai']) !!}
                          </div>
                          <div class="col-md-4">
                            {!! Form::select('nama_perusahaan', $perusahaan, request()->has('nama_perusahaan') ? request()->get('nama_perusahaan') : '', ['class'=>'form-control','placeholder'=>'-- Semua Perusahaan Penjamin --']) !!}
                          </div>
                          <div class="col-md-5">
                              <button type="submit" class="btn btn-danger" style="margin-right: 10px"><i class="fa fa-cogs" aria-hidden="true"></i>Filter Laporan</button>
                              <button type="submit" name="action" value="download" class="btn btn-success btn btn-sm"><i class="fa fa-download"></i> Download Excel</button>
                          </div>
                        </div>
                    </td>
                </tr>
            </table>
            {!! Form::close() !!}
            <hr>
            <table class="table table-bordered table-striped" id="laporan-tagihan-table">
              <thead>
                <tr>
                  <th width="10">No</th>
                  <th>Tanggal</th>
                  <th>Nomor RM</th>
                  <th>Nama Pasien</th>
                  <th>Nama Tindakan</th>
                  <th>Tarif Tindakan</th>
                  <th>Poliklinik</th>
                  <th>Perusahaan Penjamin</th>
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
<script src="{{asset('adminlte/bower_components/jquery/dist/jquery-1.12.1.min.js')}}"></script>
<!-- DataTables -->
<script src="{{asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('adminlte/bower_components/jquery-ui/jquery-ui.min.js')}}"></script>
<script src="{{asset('jquery-ui-month-picker-master/src/MonthPicker.js')}}"></script>
<script>
  $(function() {
    $('#NoIconDemo').MonthPicker({ Button: false });
    $("#NoIconDemo").MonthPicker('option', 'MonthFormat','yy-mm');

    var queryString = window.location.search;
    if(queryString=='')
    {
      var periode = '?'+$(".periode").val();
    }else{
      var periode = queryString;
      
    }

    $('#laporan-tagihan-table').DataTable({
      processing: true,
      serverSide: true,
      ajax: '/laporan-tagihan'+periode,
      columns: 
      [
        {
          data: 'DT_RowIndex',
          orderable: false,
          searchable: false
        },
        {
          data: 'tanggal',
          name: 'tanggal'
        },
        {
          data: 'nomor_rekam_medis',
          name: 'nomor_rekam_medis'
        },
        {
          data: 'nama_pasien',
          name: 'nama_pasien'
        },
        {
          data: 'nama_tindakan',
          name: 'nama_tindakan'
        },
        {
          data: 'tarif_total',
          name: 'tarif_total'
        },
        {
          data: 'poliklinik',
          name: 'poliklinik'
        },
        {
          data: 'perusahaan_asuransi',
          name: 'perusahaan_asuransi'
        },
      ]
    });
  });
</script>
@endpush

@push('css')
<link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('adminlte/bower_components/jquery-ui/themes/smoothness/jquery-ui.css')}}">
<link rel="stylesheet" href="{{asset('jquery-ui-month-picker-master/src/MonthPicker.css')}}">
@endpush