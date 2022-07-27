@extends('layouts.app')
@section('title','Tambah Akun')
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Kelola Akun
      <small>Tambah Akun</small>
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
            {!! Form::open(['route'=>'akun.store','class'=>'form-horizontal']) !!}
            @include('validation_error')
            @include('akun.form')
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection