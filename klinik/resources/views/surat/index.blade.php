@extends('layouts.app')
@section('title','Kelola Data Surat Sehat Dan Sakit')
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Daftar Surat
      <small>Daftar Surat Sehat,Sakit, Rujukan Dan Buta Warna</small>
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
            <table class="table table-bordered table-striped" id="surat-table">
              <thead>
                <tr>
                  <th width="10">Nomor</th>
                  <th>Tanggal</th>
                  <th>NOMOR REKAMEDIS</th>
                  <th>Nama Pasien</th>
                  <th>Jenis Surat</th>
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
    $('#surat-table').DataTable({
      processing: true,
      serverSide: true,
      ajax: '/surat',
      columns: [{
          data: 'DT_RowIndex',
          orderable: false,
          searchable: false
        },
        {
          data: 'created_at',
          name: 'created_at'
        },
        {
          data: 'pendaftaran.pasien.nomor_rekam_medis',
          name: 'pendaftaran.pasien.nomor_rekam_medis'
        },
        {
          data: 'pendaftaran.pasien.nama',
          name: 'pendaftaran.pasien.nama'
        },
        {
          data: 'jenis_surat',
          name: 'jenis_surat'
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