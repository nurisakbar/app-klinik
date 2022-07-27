@extends('layouts.app')
@section('title','Kelola Data Kehadiran Pegawai')
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Kelola Data Kehadiran Pegawai
      <small>Daftar Kehadiran Pegawai</small>
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
            <a href="{{route('kehadiran-pegawai.create')}}" class="btn btn-info btn-social btn-flat " style="margin-right: 5px"><i class="fa fa-plus-square-o" aria-hidden="true"></i>
              Tambah Data</a>
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-export">
                <i class="fa fa-download"></i> Export Excel
              </button>
              <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-import">
                <i class="fa fa-file-excel-o"></i> Import Data Kehadiran
                </button>
            <hr>
            @include('alert')
            {!! Form::open(['url'=>'kehadiran-pegawai','method'=>'GET']) !!}
            <table class="table table-bordered">
                <tr>
                    <td width="200">Tanggal Mulai</td>
                    <td>
                        <div class="row">
                            <div class="col-md-3">
                              {!! Form::date('tanggal_awal', $tanggal_awal, ['class'=>'form-control','placeholder'=>'Tanggal Mulai']) !!}
                            </div>
                            <div class="col-md-3">
                              {!! Form::date('tanggal_akhir', $tanggal_akhir, ['class'=>'form-control','placeholder'=>'Tanggal Mulai']) !!}
                            </div>
                            <div class="col-md-3">
                              {!! Form::select('kelompok_pegawai_id', $kelompok_pegawai, null, ['class'=>'form-control','placeholder'=>'--SEMUA KELOMPOK PEGAWAI--']) !!}
                            </div>
                            <div class="col-md-3">
                                <button type="submit" name="type" value="web" class="btn btn-danger"><i class="fa fa-cogs" aria-hidden="true"></i>
                                   Filter Laporan</button>
                                {{-- <button type="submit" name="type" value="excel" class="btn btn-success" style="float:right"><i class="fa fa-file-excel-o" aria-hidden="true"></i>
                                   Download Excel</button> --}}
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
            {!! Form::close() !!}
            <table class="table table-bordered table-striped" id="kehadiran-pegawai-table">
              <thead>
                <tr>
                  <th>NIP</th>
                  <th>Nama</th>
                  <th>Shift</th>
                  <th>Jam Masuk</th>
                  <th>Jam Keluar</th>
                  <th>Tanggal</th>
                  <th>Status Kehadiran</th>
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

<!-- Modal Import Excel-->
{!! Form::open(['route'=>'kehadiran-pegawai.import_excel', 'files' => true]) !!}
<div class="modal fade" id="modal-import" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Import Data Kehadiran</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="callout callout-info" role="alert">
            Extension File Excel Harus .XLSX 
          </div>
          <table class="table table-bordered">
              <tr>
                  <td>Pilih File Excel</td>
                  <td>
                      {!! Form::file('import_file', ['class' => 'form-control']) !!}
                  </td>
              </tr>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Upload</button>
        </div>
      </div>
    </div>
  </div>
{!! Form::close() !!}

<!-- Modal Export Excel-->
<div class="modal fade" id="modal-export" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Export data kehadiran pegawai</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      {{ Form::open(['route' => 'kehadiran-pegawai.export_excel', 'method' => 'post']) }}
      <div class="modal-body">
        <table class="table table-bordered">
          <tr>
            <th>Tanggal Mulai</th>
            <td><input type="date" name="tanggal_mulai" class="form-control"></td>
          </tr>
          <tr>
            <th>Tanggal Selesai</th>
            <td><input type="date" name="tanggal_selesai" class="form-control"></td>
          </tr>
          <tr>
            <th>Kelompok Pegawai</th>
            <td>{!! Form::select('kelompok_pegawai_id', $kelompok_pegawai, null, ['class'=>'form-control','placeholder'=>'--SEMUA KELOMPOK PEGAWAI--']) !!}</td>
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
    $('#kehadiran-pegawai-table').DataTable({
      processing: true,
      serverSide: true,
      ajax: "/kehadiran-pegawai?tanggal_awal={{$tanggal_awal}}&tanggal_akhir={{$tanggal_akhir}}&kelompok_pegawai_id={{$kelompok_pegawai_id}}&type=web",
      columns: [
        {
          data: 'nip',
          name: 'nip'
        },
        {
          data: 'nama',
          name: 'nama'
        },
        {
          data: 'nama_shift',
          name: 'nama_shift'
        },
        {
          data: 'jam_masuk',
          name: 'jam_masuk'
        },
        {
          data: 'jam_keluar',
          name: 'jam_keluar'
        },
        {
          data: 'tanggal',
          name: 'tanggal'
        },
        {
          data: 'status',
          name: 'status'
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