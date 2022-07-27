@extends('layouts.app')
@section('title','Tambah' . ($tipe == 'surat-sehat') ? 'Surat Sehat' : 'Surat Sakit'  )
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Kelola {{ ($tipe == 'surat-sehat') ? 'Surat Sehat' : 'Surat Sakit' }}
      <small>Tambah {{ ($tipe == 'surat-sehat') ? 'Surat Sehat' : 'Surat Sakit' }}</small>
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
            <?php $url = ''?>
            <?php 
              if($tipe == 'surat-sehat') {
                $url = 'surat-sehat.store_sehat';
              } else {
                $url = 'surat-sakit.store_sakit';
              }
            ?>
            {!! Form::open(['route'=>"$url",'class'=>'form-horizontal']) !!}
            @include('validation_error')
            @include('surat-sehat-sakit.form')
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection