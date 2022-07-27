@extends('layouts.app')
@section('title','Daftar Periode')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Daftar Buku Besar {{ $akun->nama }}
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
                    <div class="row">
                        <div class="col-md-4">
                            <h3>Buku Besar {{ $akun->nama }}</h3>
                        </div>
                        <div class="col-md-4">
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Bulan</label>
                                    <div class="col-sm-10">
                                        <select name="bulan" class="form-control">
                                            <@foreach($dates as $date)
                                            <option value="">{{ $date->month }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" style="margin-top: 10px">Tahun</label>
                                    <div class="col-sm-10">
                                        <select name="tahun" class="form-control" style="margin-top: 10px">
                                            @foreach($dates as $date)
                                            <option value="{{ $date->year }}">{{ $date->year }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10 text-right">
                                        <button class="btn btn-info" style="margin-top: 10px">Cari</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                  <div class="row" style="margin-top: 20px">
                      <div class="col-md-12">
                          <table class="table table-striped text-center">
                              <thead>
                                  <tr>
                                      <th>No</th>
                                      <th>Waktu</th>
                                      <th>Action </th>
                                  </tr>
                              </thead>
                              <tbody>
                                  @foreach($dates as $date)
                                  <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $date->month }} {{ $date->year }} </td>
                                    <td>
                                        <a href="{{ url('buku-besar/' . $kode . '') }}" class="btn btn-info"><i class="fa fa-eye"></i></a>
                                    </td>
                                  </tr>
                                  @endforeach
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </section>
  </div>
@endsection
