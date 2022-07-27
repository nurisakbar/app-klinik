@extends('layouts.app')
@section('title','Jadwal Praktek Dokter')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Jadwal Praktek Dokter
        <small>Setting Aplikasi</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <div class="box">
                    <div class="box-body text-center">
                        <img src="https://img.freepik.com/free-vector/doctor-character-background_1270-84.jpg?size=338&ext=jpg" width="230">
                        <h4>Dokter {{ $user->name }}</h4>
                        {{ Date('l')}}
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="box">
                    <div class="box-body">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                            <i class="fa fa-plus"></i> Tambah Jadwal
                        </button>
                        <hr>
                        <table class="table table-bordered table-striped" id="jadwal-praktek-table">
                            <thead>
                                <tr>
                                    <th width="20px">Nomor</th>
                                    <th>Hari</th>
                                    <th>Jam</th>
                                    <th>Poliklinik</th>
                                    <th width="60">Action</th>
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
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Form Tambah Jadwal Dokter</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        {!! Form::open(['route'=>'jadwal-praktek.store','class'=>'form-horizontal']) !!}
        <div class="modal-body">
          @include('validation_error')
          @include('jadwal-praktek.form')
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
@endsection

@push('scripts')
<script src="{{asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script>
$(document).ready( function () {
  $(function() {
    $('#jadwal-praktek-table').DataTable({
      processing: true,
      serverSide: true,
      ajax: '/jadwal-praktek?user_id=' + {{ $user->id }} + '',
      columns: [{
          data: 'DT_RowIndex',
          orderable: false,
          searchable: false
        },
        {
          data: 'hari',
          name: 'hari'
        },
        {
          data: 'jam',
          name: 'jam'
        },
        {
          data: 'poliklinik.nama',
          name: 'poliklinik.nama'
        },
        {
          data: 'action',
          name: 'action'
        }
      ]
    });
  });
} );
</script>
@endpush

@push('css')
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
@endpush
