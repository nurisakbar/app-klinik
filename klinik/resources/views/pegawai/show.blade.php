@extends('layouts.app')
@section('title','Kelola Data Detail Pegawai')
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Kelola Data Detail Pegawai
      <small>Data Detail Pegawai</small>
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
            <a href="/pegawai" class="btn btn-primary">Kembali</a>
          </div>
        </div>
      </div>
      <div class="col-md-9">
        <div class="box">
          <div class="box-body">
            <ul class="nav nav-tabs">
              <li role="presentation" class="{{ ($_GET['tab'] == 'komponen_gaji') ? 'active':''}}"><a href="/pegawai/{{$pegawai->id}}?tab=komponen_gaji" >Komponen Gaji</a></li>
              <li role="presentation" class="{{ ($_GET['tab'] == 'jadwal_kerja') ? 'active':''}}"><a href="/pegawai/{{$pegawai->id}}?tab=jadwal_kerja" >Jadwal Kerja</a></li>
              <li role="presentation" class="{{ ($_GET['tab'] == 'lain_lain') ? 'active':''}}"><a href="/pegawai/{{$pegawai->id}}?tab=lain_lain" >Lain Lain</a></li>
            </ul>
            <hr>
            @if($_GET['tab']=='komponen_gaji')
            @include('pegawai.komponen_gaji')
            @elseif($_GET['tab']=='jadwal_kerja')
            @include('pegawai.jadwal_kerja')
            @elseif($_GET['tab']=='lain_lain')
            @include('pegawai.lain_lain')
            @endif
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
      {!! Form::open(['route'=>'tunjangan-gaji.store','class'=>'form-horizontal']) !!}
      <div class="modal-body">
        @include('validation_error')
        @include('tunjangan-gaji-pegawai.form')
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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
    $('#komponen-gaji-table').DataTable({
      destroy: true
      processing: true,
      serverSide: true,
      ajax: '/tunjangan-gaji?pegawai_id=' + {{ $pegawai->id }} +'',
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
          data: 'keterangan',
          name: 'keterangan'
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