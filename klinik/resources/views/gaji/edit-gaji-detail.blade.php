@extends('layouts.app')
@section('title','Edit Komponen Gaji Detail')
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Edit Komponen Gaji Detail
      <small>Edit Komponen Gaji Detail Pegawai</small>
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
            {!! Form::model($gajiDetail,['route'=>['gaji-detail.update',$gajiDetail->id],'method'=>'PUT','class'=>'form-horizontal']) !!}
            @include('validation_error')
            @include('gaji.komponen-gaji-form')
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection