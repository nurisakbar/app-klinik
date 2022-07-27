@extends('layouts.app')
@section('title','Laporan Data Tindakan')
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Laporan Tindakan
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
            {!! Form::open(['url'=>'laporan-tindakan','method'=>'GET']) !!}
            <table class="table table-bordered">
                <tr>
                    <td width="200">Periode</td>
                    <td>
                        <div class="row">
                          <div class="col-md-3">
                            {!! Form::month('periode', $periode, ['class'=>'form-control periode','id'=>'NoIconDemo','placeholder'=>'Tanggal Mulai']) !!}
                          </div>
                          <div class="col-md-5">
                              <button type="submit" name="action" value="download" class="btn btn-success btn btn-sm"><i class="fa fa-download"></i> Download Excel</button>
                          </div>
                        </div>
                    </td>
                </tr>
            </table>
            {!! Form::close() !!}
            <hr>
            @include('alert')
            <table class="table table-bordered table-striped" id="users-table">
              <thead>
                <tr>
                  <th width="10">Nomor</th>
                  <th>Tanggal</th>
                  <th>No RM</th>
                  <th>Nama Pasien</th>
                  <th>Nama Tindakan</th>
                  <th>Tarif Tindakan</th>
                  <th>Dokter</th>
                  <th>Poliklinik</th>
                  <th>Perusahaan</th>
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
      ajax: '/laporan-tindakan',
      columns: [{
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
          data: 'nama',
          name: 'nama'
        },
        {
          data: 'tindakan',
          name: 'tindakan'
        },
        {
          data: 'tarif_total',
          name: 'tarif_total'
        },
        {
          data: 'dokter',
          name: 'dokter'
        },
        {
          data: 'poliklinik',
          name: 'poliklinik'
        },
        {
          data: 'nama_perusahaan',
          name: 'nama_perusahaan'
        },
        {
          data: 'action',
          name: 'action'
        }
      ]
    });
  });
</script>
@endpush

@push('css')
<link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
@endpush