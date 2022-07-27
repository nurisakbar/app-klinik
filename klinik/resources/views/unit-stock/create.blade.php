@extends('layouts.app')
@section('title','Tambah Unit Stock')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Kelola Unit Stock
        <small>Tambah Unit Stock</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard" aria-hidden="true"></i> Home</a></li>
        <li><a href="/unit-stock">Unit Stock</a></li>
        <li class="active">Create Unit Stock</li>
      </ol>
    </section>

    <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-body">
                  {!! Form::open(['route'=>'unit-stock.store','class'=>'form-horizontal']) !!}
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
