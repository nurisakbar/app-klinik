@extends('layouts.app')
@section('title','Kelola Jadwal Kerja Pegawai')
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Kelola Jadwal Kerja 
      <small>Atur Jadwal Kerja Pegawai</small>
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
            @if($pegawai_shift->first())
            <h4>Daftar Jadwal Kerja Pegawai Bernama <b>{{ $pegawai_shift[0]->pegawai->nama }}</b></h4>
            @foreach($pegawai_shift as $pegawai)
            <div class="row input-form" style="margin: 15px 0">
              <div class="col-md-4">
                <label for="">Tanggal Kerja</label>
                <input type="hidden" name="pegawai_id" value="{{ $_GET['pegawai'] }}">
                <input type="date" name="tanggal[]" value="{{ $pegawai->tanggal }}" class="form-control">
              </div>
              <div class="col-md-4">
                <label for="">Shift</label>
                {!! Form::select('shift_id[]',$shift, $pegawai->shift_id, ['class'=>'form-control','Placeholder'=>'shift']) !!}
              </div>
            </div>
            @endforeach
            @endif
            <hr>
            {!! Form::open(['route'=>'pegawai.atur-jadwal.store','class'=>'form-horizontal']) !!}
            <h4>Tambah Jadwal Kerja</h4>
            <div class="row input-form" style="margin: 15px 0">
              <div class="col-md-4">
                <label for="">Tanggal Kerja</label>
                <input type="hidden" name="pegawai_id" value="{{ $_GET['pegawai'] }}">
                <input type="date" name="tanggal[]" class="form-control">
              </div>
              <div class="col-md-4">
                <label for="">Shift</label>
                {!! Form::select('shift_id[]',$shift, null, ['class'=>'form-control','Placeholder'=>'shift']) !!}
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-3">
                <table class="table">
                  <tr>
                    <th><button id="btn-add" type="button" class="btn btn-danger"><i class="fa fa-plus"></i> Tambah Form</button></th>
                    <th><button type="submit" class="btn btn-danger"><i class="fa fa-save"></i> Simpan</button></th>
                    <th><a href="{{ url('pegawai/' . $_GET['pegawai']) . '?tab=jadwal_kerja' }}" class="btn btn-danger"><i class="fa fa-sign-out"></i> Kembali</a></th>
                  </tr>
                </table>
              </div>
            </div>
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
@push('scripts')
<script src="{{asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script>
$(document).ready( function () {
    $('#btn-add').click(function() {
      let newInput = $(".input-form:last").clone();
      $(newInput).insertAfter(".input-form:last");
    })
} );
</script>
@endpush