@extends('layouts.app')
@section('title','Detail Pasien')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Detail Informasi Pasien
        <small>(Biodata, Riwayat Kunjungan, Iterasi Pasien ) </small>
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
                <ul class="nav nav-tabs">
                  @if(!isset($_GET['tab']))
                    <li class="active"><a href="/pasien/{{$pasien->id}}">Bodata Pasien</a></li>
                  @else
                    <li ><a href="/pasien/{{$pasien->id}}">Bodata Pasien</a></li>
                  @endif
                  
                  <li><a href="/pasien/{{$pasien->id}}?tab=riwayat_kunjungan">Riwayat Kunjungan</a></li>
                  <li><a href="/pasien/{{$pasien->id}}?tab=riwayat_iterasi">Riwayat Iterasi</a></li>
                </ul>
                <hr>
                  {!! Form::model($pasien,['route'=>['pasien.update',$pasien->id],'method'=>'PUT']) !!}
                  @include('validation_error')
                  @if(!isset($_GET['tab']))
                    @include('pasien.form')
                  @elseif($_GET['tab'] =='riwayat_iterasi')
                    @include('pasien.riwayat_iterasi')
                  @else
                    @include('pasien.riwayat_kunjungan')
                  @endif
                 
                  {!! Form::close() !!}
              </div>
            </div>
          </div>
        </div>
      </section>
  </div>
@endsection
