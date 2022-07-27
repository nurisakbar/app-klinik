@extends('layouts.app')
@section('title','Laporan Transaksi')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Laporan Transaksi
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
                {!! Form::open(['url'=>'laporan-transaksi','method'=>'GET','id'=>'form']) !!}
                <table class="table table-bordered">
                    <tr>
                        <td width="140">Tanggal Mulai</td>
                        <td>
                            <div class="row">
                                <div class="col-md-2">
                                  {!! Form::date('tanggal_awal', $tanggal_awal, ['class'=>'form-control','placeholder'=>'Tanggal Mulai']) !!}
                                </div>
                                <div class="col-md-2">
                                  {!! Form::date('tanggal_akhir', $tanggal_akhir, ['class'=>'form-control','placeholder'=>'Tanggal Mulai']) !!}
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" name="type" value="web" class="btn btn-danger"><i class="fa fa-cogs" aria-hidden="true"></i>
                                        Filter Laporan
                                    </button>
                                    <button type="button" value="export_excel" class="btn btn-success" data-toggle="modal" data-target="#export-modal">Export Excel</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
                {!! Form::close() !!}
                <hr>
                @include('alert')
                <table class="table table-bordered table-striped" id="laporan-table">
                  <thead>
                      <tr>
                        <th width="10">No</th>
                        <th>Tanggal</th>
                        <th>Nomor Pendaftaran</th>
                        <th>Nomor RM</th>
                        <th>Nama Pasien</th>
                        <th>Jenis Layanan</th>
                        <th>Total Transaksi</th>
                        <th>Jenis Pembayaran</th>
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
  <!-- Modal -->
  {!! Form::open(['route'=>'pendaftaran.import_excel', 'files' => true]) !!}
    <div class="modal fade" id="import-stock" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Import Data Calon Pasien</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <table class="table table-bordered">
                <tr>
                    <td>Pilih File</td>
                    <td>
                        {!! Form::file('import_file', ['class' => 'form-control']) !!}
                    </td>
                </tr>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Upload Calon Pasien</button>
          </div>
        </div>
      </div>
    </div>
  {!! Form::close() !!}

    <!-- Modal -->
    <div class="modal fade" id="export-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Export Laporan Transaksi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          {{ Form::open(['route' => 'laporan-transaksi.export_excel', 'method' => 'POST']) }}
          <div class="modal-body">
            <table class="table table-bordered">
              <tr>
                <td>Tanggal Mulai</td>
                <td><input type="date" name="tanggal" class="form-control" required></td>
              </tr>
              <tr>
                <td>Shift</td>
                <td>
                  
                  <select name="nama_shift" class="form-control">
                    <option value="">-- Semua Shift--</option>
                    @foreach($shift as $shf)
                      <option value="{{ $shf['nama_shift']}}">{{ $shf['nama_shift']}}</option>
                    @endforeach
                  </select>
                </td>
              </tr>
              <tr>
                <td>Poliklinik</td>
                <td>{{ Form::select('poliklinik_id',$poliklinik,null,['class' => 'form-control','placeholder'=>'-- Semua Poli --'])}}</td>
              </tr>
              <tr>
                <td>Jenis Pembayaran</td>
                <td>
                  {!! Form::select('metode_pembayaran', array_merge(['' => '--SEMUA METODE PEMBAYARAN--'] + $metodePembayaran) ,null, ['class'=>'form-control','Placeholder'=>'Nama Obat']) !!}
                </td>
              </tr>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Download</button>
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
      $('#laporan-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "/laporan-transaksi?tanggal_awal={{$tanggal_awal}}&tanggal_akhir={{$tanggal_akhir}}&type=web",
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
            data: 'kode',
            name: 'kode'
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
            data: 'nama_perusahaan',
            name: 'nama_perusahaan'
          },
          {
            data: 'total_transaksi',
            name: 'total_transaksi'
          },
          {
            data: 'metode_pembayaran',
            name: 'metode_pembayaran'
          },
          {
            data: 'action',
            name: 'action'
          },
        ]
      });
    });
</script>
@endpush

@push('css')
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
@endpush
