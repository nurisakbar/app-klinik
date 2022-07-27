@extends('layouts.app')
@section('title','Tambah Satuan')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Buat Jenis Pemeriksaan Laboratorium
        <small>Buat data jenis pemeriksaan baru</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="/jenis-pemeriksaan-lab">Jenis Pemeriksaan Laboratorium </a></li>
        <li class="active">Buat Data</li>
      </ol>
    </section>

    <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-body">
                  {!! Form::open(['route'=>'jenis-pemeriksaan-lab.store','class'=>'form-horizontal']) !!}
                  @include('validation_error')
                  @include('jenis-pemeriksaan-laboratorium.form')
                  {!! Form::close() !!}
              </div>
            </div>
          </div>
        </div>
      </section>
  </div>
@endsection
