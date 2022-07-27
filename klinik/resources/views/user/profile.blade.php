@extends('layouts.app')
@section('title','Profile Pengguna')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Halaman Profile
        <small>Profile Pengguna</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-3">
                <div class="box">
                  <div class="box-body">
                    <img class="profile-user-img img-responsive img-circle" src="{{asset('adminlte/dist/img/user4-128x128.jpg')}}" alt="User profile picture">

                    <h3 class="profile-username text-center"> {{ Auth::user()->name}}</h3>
                    <p class="text-muted text-center">{{ Auth::user()->role}}</p>
                  </div>
                </div>
            </div>
          <div class="col-xs-9">
            <div class="box">
              <div class="box-body">
                  {!! Form::model($user,['route'=>['user.profile'],'method'=>'PUT','class'=>'form-horizontal']) !!}
                  @include('validation_error')
                  @include('alert')
                    <div class="form-group">
                      <label for="inputName" class="col-sm-2 control-label">Nama</label>
  
                      <div class="col-sm-10">
                        {!! Form::text('name', null, ['class'=>'form-control','Placeholder'=>'Nama Pengguna']) !!}
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail" class="col-sm-2 control-label">Email</label>
  
                      <div class="col-sm-10">
                        {!! Form::email('email', null, ['class'=>'form-control','Placeholder'=>'Email']) !!}
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputName" class="col-sm-2 control-label">Password</label>
  
                      <div class="col-sm-10">
                        {!! Form::password('password', ['class'=>'form-control','Placeholder'=>'Password']) !!}
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-danger btn btn-sm"><i class="fa fa-floppy-o" aria-hidden="true"></i> Update Profile</button>
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
