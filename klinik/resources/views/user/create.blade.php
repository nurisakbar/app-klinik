@extends('layouts.app')
@section('title','Tambah Pengguna')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Kelola Pengguna
        <small>Tambah Pengguna</small>
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
                  {!! Form::open(['route'=>'user.store','class'=>'form-horizontal']) !!}
                  @include('validation_error')
                  @include('user.form')
                  {!! Form::close() !!}
              </div>
            </div>
          </div>
        </div>
      </section>
  </div>
@endsection
