@extends('layouts.app')
@section('title','Komponen Gaji Detail')
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Komponen Gaji Detail
      <small>Periode {{ $gaji->periode }}</small>
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
            <img src="https://img.freepik.com/free-vector/man-shows-gesture-great-idea_10045-637.jpg?size=338&ext=jpg" width="230">
            <h4>{{ $pegawai->nama }}</h4>
          </div>
        </div>
      </div>
      <div class="col-md-9">
        <div class="box">
          <div class="box-body">
            @if (auth()->user()->role != 'pimpinan')
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#komponen-modal">
              <i class="fa fa-plus"></i> Tambah Komponen Gaji
            </button>
            @endif
            <a href="/gaji/{{ $gaji->id }}/cetak" target="new" class="btn btn-primary"><i class="fa fa-print" aria-hidden="true"></i>
               Cetak Slip Gaji</a>
               <a href="/gaji" class="btn btn-primary"><i class="fa fa-share-square-o" aria-hidden="true"></i> Kembali</a>
            <hr>
            <table class="table table-bordered table-striped" id="komponen-table">
              <thead>
                <tr>
                  <th width="20px">Nomor</th>
                  <th>Komponen Gaji</th>
                  <th>Jumlah</th>
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

<!-- Modal komponen gaji -->
<div class="modal fade" id="komponen-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Form Tambah Komponen Gaji</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      {!! Form::open(['route'=>'gaji.store','class'=>'form-horizontal']) !!}
      <div class="modal-body">
        @include('validation_error')
        @include('gaji.komponen-gaji-form')
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
<!-- DataTables -->
<script src="{{asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script>
  $(function() {
    $('#komponen-table').DataTable({
      processing: true,
      serverSide: true,
      ajax: "/gaji/{{ $gaji->id }}/edit",
      columns: [{
          data: 'DT_RowIndex',
          orderable: false,
          searchable: false
        },
        {
          data: 'komponen_gaji.nama_komponen',
          name: 'komponen_gaji.nama_komponen'
        },
        {
          data: 'jumlah',
          name: 'jumlah'
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