@extends('layouts.app')
@section('title','Edit Akun')
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Kelola Jurnal Umum
      <small>Edit Jurnal Umum</small>
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
            {!! Form::model($jurnal,['route'=>['jurnal.update',$jurnal->id],'method'=>'PUT','class'=>'form-horizontal']) !!}
            @include('validation_error')
            <div class="form-group">
              <label class="col-sm-2 control-label">Tanggal</label>
              <div class="col-sm-2">
                  {!! Form::date('tanggal', null, ['class'=>'form-control']) !!}
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Akun</label>
              <div class="col-sm-10">
                  {!! Form::select('akun_id', $akunList, null, ['class'=>'form-control','Placeholder'=>'Akun']) !!}
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Nominal Rp.</label>
              <div class="col-sm-10">
                  {!! Form::number('nominal', null, ['class'=>'form-control','Placeholder'=>'Nominal']) !!}
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Keterangan</label>
              <div class="col-sm-10">
                  {!! Form::text('keterangan', null, ['class'=>'form-control','Placeholder'=>'Keterangan']) !!}
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">Tipe</label>
              <div class="col-sm-10">
                  {!! Form::select('tipe', ['debet' => 'DEBET', 'kredit' => 'KREDIT'],null, ['class' => 'form-control']); !!}
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