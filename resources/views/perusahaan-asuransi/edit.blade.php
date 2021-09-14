@extends('layouts.app')
@section('title','Edit Perusahaan Asuransi')
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Kelola Perusahaan Asuransi
      <small>Edit Perusahaan Asuransi</small>
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
            {!! Form::model($asuransi,['route'=>['asuransi.update',$asuransi->id],'method'=>'PUT','class'=>'form-horizontal']) !!}
            @include('validation_error')
            @include('perusahaan-asuransi.form')
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection