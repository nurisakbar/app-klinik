@extends('layouts.app')
@section('title','Setting Aplikasi')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Halaman Setting
        <small>Setting Aplikasi</small>
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
                    <table class="table table-bordered text-center">
                      <tr>
                        <th>Logo Instansi</th>
                      </tr>
                      <tr>
                        <td>
                          <?php
                          $logo = $setting->logo==null?'default_logo.jpg':$setting->logo;
                          ?>
                          <img class="profile-user-img img-responsive img-circle" src="{{asset('image/'.$logo)}}" alt="User profile picture">
                        </td>
                      </tr>
                    </table>          
                  </div>
                </div>
            </div>
          <div class="col-xs-9">
            <div class="box">
              <div class="box-body">
                  {!! Form::model($setting,['route'=>['setting.update'],'method'=>'PUT','class'=>'form-horizontal','files'=>true]) !!}
                  @include('validation_error')
                  @include('alert')
                    <div class="form-group">
                      <label for="inputName" class="col-sm-2 control-label">Nama Klinik</label>
  
                      <div class="col-sm-10">
                        {!! Form::text('nama_instansi', null, ['class'=>'form-control','Placeholder'=>'Nama Instansi']) !!}
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail" class="col-sm-2 control-label">Email & Telpon</label>
  
                      <div class="col-sm-5">
                        {!! Form::email('email', null, ['class'=>'form-control','Placeholder'=>'Email']) !!}
                      </div>
                      <div class="col-sm-5">
                        {!! Form::text('nomor_telpon', null, ['class'=>'form-control','Placeholder'=>'Telpon']) !!}
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputName" class="col-sm-2 control-label">Alamat</label>
  
                      <div class="col-sm-10">
                        {!! Form::text('alamat',null, ['class'=>'form-control','Placeholder'=>'Alamat']) !!}
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputName" class="col-sm-2 control-label">Logo</label>
                      <div class="col-sm-10">
                        <input type="file" name="logo">
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-danger btn btn-sm"><i class="fa fa-gear" aria-hidden="true"></i> Simpan Setting</button>
                      </div>
                    </div>
                  {!! Form::close() !!}
              </div>
            </div>
            <div class="box">
              <div class="box-body">
                @if(\Session::has('success'))
                  <div class="alert alert-success">
                    {{ \Session::get('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                @endif
                <h3>Daftar / Login Device untuk notifikasi whatsapp</h3>
                <div class="row">
                  <div class="col-md-12">
                    <!-- Custom Tabs -->
                    <div class="nav-tabs-custom">
                      <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_1" data-toggle="tab">Login</a></li>
                        <li><a href="#tab_2" data-toggle="tab">Register</a></li>
                      </ul>
                      <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                          <form action="{{ url('device?login=true') }}" method="POST">
                            @CSRF
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  @if(\Session::has('messageErr'))
                                    <div class="alert alert-danger">{{ \Session::get('messageErr') }}</div>
                                  @endif
                                  <label for="">Login Device</label> <br>
                                  <small>Sampel : samsung-galaxy-s21</small>
                                  <div class="input-group input-group-sm">
                                    <input type="text" name="device" required class="form-control" placeholder="Masukan nama device">
                                    <span class="input-group-btn">
                                      <button type="submit" class="btn btn-info btn-flat">Submit</button>
                                    </span>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="tab_2">
                          <form action="{{ url('device') }}" method="POST">
                            @CSRF
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  @if(\Session::has('messageErr'))
                                    <div class="alert alert-danger">{{ \Session::get('messageErr') }}</div>
                                  @endif
                                  <label for="">Register Device</label> <br>
                                  <small>Sampel : samsung-galaxy-s21</small>
                                  <div class="input-group input-group-sm">
                                    <input type="text" name="device" required class="form-control" placeholder="Masukan nama device">
                                    <span class="input-group-btn">
                                      <button type="submit" class="btn btn-info btn-flat">Submit</button>
                                    </span>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                      <!-- /.tab-content -->
                    </div>
                    <!-- nav-tabs-custom -->
                  </div>
                  <!-- /.col -->   
                  <div class="col-md-12">
                    <h4>Daftar device yang sudah terdaftar dalam sistem</h4>
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Device</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($deviceStatus as $device)
                          <tr>
                            <td>{!! $device->id !!}</td>
                            <td>{!! $device->status !!}</td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>  
                  </div>       
                </div>
                <!-- /.row -->
                <!-- END CUSTOM TABS -->
              </div>
            </div>
          </div>
        </div>
      </section>
  </div>
@endsection
