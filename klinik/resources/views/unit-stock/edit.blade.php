@extends('layouts.app')
@section('title','Edit Unit Stock')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Kelola Unit Stock
        <small>Edit Unit Stock {{$unit_stock->nama_unit}}</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard" aria-hidden="true"></i> Home</a></li>
        <li><a href="/unit-stock">Unit Stock</a></li>
        <li class="active">Edit Unit Stock {{$unit_stock->nama_unit}}</li>
      </ol>
    </section>

    <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-body">
                  {!! Form::model($unit_stock,['route'=>['unit-stock.update',$unit_stock->id],'method'=>'PUT','class'=>'form-horizontal']) !!}
                  @include('validation_error')
                  @include('unit-stock.form')
                  {!! Form::close() !!}
              </div>
            </div>
          </div>
        </div>
      </section>
  </div>
@endsection
