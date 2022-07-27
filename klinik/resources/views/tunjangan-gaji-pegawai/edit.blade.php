@extends('layouts.app')
@section('title','Edit Jadwal Tunjangan Gaji Pegawai')
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Kelola Tunjangan Gaji Pegawai
      <small>Edit Tunjangan Gaji Pegawai</small>
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
            {!! Form::model($tunjangan_gaji,['route'=>['tunjangan-gaji.update',$tunjangan_gaji->id],'method'=>'PUT','class'=>'form-horizontal']) !!}
            @include('validation_error')
            @include('tunjangan-gaji-pegawai.form')
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection