@extends('layouts.app')
@section('title','Edit Pasien')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Kelola Pasien
        <small>Edit Pasien</small>
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
                
                  {!! Form::model($pasien,['route'=>['pasien.update',$pasien->id],'method'=>'PUT']) !!}
                  @include('validation_error')
                  @include('pasien.form')
                  {!! Form::close() !!}
              </div>
            </div>
          </div>
        </div>
      </section>
  </div>
@endsection
