@extends('layouts.topnavlayout')
@section('title','Pendaftaran Pasien Baru')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Tanda Tanda Vital Dan Pemeriksa Klinis
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <section class="content">
      {{ Form::open(['url'=>'simpan-pemeriksaan-klinis'])}}
      {{ Form::hidden('pendaftaran_id',$nomorAntrian->id)}}
        <div class="row">
          <div class="col-xs-8">
            <div class="box">
              <div class="box-body" style="padding-bottom:65px">
                  @include('validation_error')
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group col-sm-11">
                        <label>Berat Badan</label>
                        {!! Form::text('berat_badan', $nomorAntrian->pendaftaran->tanda_tanda_vital['berat_badan'], ['disabled' => 'disabled','class'=>'form-control berat_badan','Placeholder'=>'Berat Badan','onKeyUp'=>'hitungIMT()']) !!}
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group col-sm-11">
                        <label>Tinggi Badan</label>
                        {!! Form::text('tinggi_badan', $nomorAntrian->pendaftaran->tanda_tanda_vital['tinggi_badan'], ['disabled' => 'disabled','class'=>'form-control tinggi_badan','Placeholder'=>'Tinggi Badan','onKeyUp'=>'hitungIMT()']) !!}
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group col-sm-11">
                        <label>Tekanan Darah</label>
                        {!! Form::text('tekanan_darah', $nomorAntrian->pendaftaran->tanda_tanda_vital['tekanan_darah'], ['disabled' => 'disabled','class'=>'form-control','Placeholder'=>'Tekanan Darah']) !!}
                      </div>
                    </div>


                    <div class="col-md-3">
                      <div class="form-group col-sm-11">
                        <label>Suhu Tubuh</label>
                        {!! Form::text('suhu_tubuh', $nomorAntrian->pendaftaran->tanda_tanda_vital['suhu_tubuh'], ['disabled' => 'disabled','class'=>'form-control','Placeholder'=>'Suhu Tubuh']) !!}
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group col-sm-11">
                        <label>Nadi</label>
                        {!! Form::text('nadi', $nomorAntrian->pendaftaran->tanda_tanda_vital['nadi'], ['disabled' => 'disabled','class'=>'form-control','Placeholder'=>'Nadi']) !!}
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group col-sm-11">
                        <label>RR</label>
                        {!! Form::text('rr', $nomorAntrian->pendaftaran->tanda_tanda_vital['rr'], ['disabled' => 'disabled','class'=>'form-control','Placeholder'=>'RR']) !!}
                      </div>
                    </div>



                    <div class="col-md-3">
                      <div class="form-group col-sm-11">
                        <label>Saturasi O2</label>
                        {!! Form::text('saturasi_o2', $nomorAntrian->pendaftaran->tanda_tanda_vital['saturasi_o2'], ['disabled' => 'disabled','class'=>'form-control','Placeholder'=>'Saturasi O2']) !!}
                      </div>
                    </div>

                    <div class="col-md-3">
                      <div class="form-group col-sm-11">
                        <label>Pernafasan</label>
                        {!! Form::text('pernafasan', $nomorAntrian->pendaftaran->tanda_tanda_vital['pernafasan'], ['disabled' => 'disabled','class'=>'form-control','Placeholder'=>'Pernafasan']) !!}
                      </div>
                    </div>

                    <div class="col-md-3">
                      <div class="form-group col-sm-11">
                        <label>Fungsi Penciuman</label>
                        {!! Form::select('fungsi_penciuman',['Normal'=>'Normal','Tidak Normal'=>'Tidak Normal'], $nomorAntrian->pendaftaran->tanda_tanda_vital['fungsi_penciuman'], ['disabled' => 'disabled','class'=>'form-control','Placeholder'=>'Fungsi Penciuman']) !!}
                      </div>
                    </div>


                    <div class="col-md-3">
                      <div class="form-group col-sm-11">
                        <label>Lingkar Perut</label>
                        {!! Form::text('lingkar_perut', $nomorAntrian->pendaftaran->tanda_tanda_vital['lingkar_perut'], ['disabled' => 'disabled','class'=>'form-control','Placeholder'=>'Lingkar Perut']) !!}
                      </div>
                    </div>

                    <div class="col-md-3">
                      <div class="form-group col-sm-11">
                        <label>DJJ</label>
                        {!! Form::text('djj', $nomorAntrian->pendaftaran->tanda_tanda_vital['djj'], ['disabled' => 'disabled','class'=>'form-control','Placeholder'=>'DJJ']) !!}
                      </div>
                    </div>

                    <div class="col-md-3">
                      <div class="form-group col-sm-11">
                        <label>TFU</label>
                        {!! Form::text('tfu', $nomorAntrian->pendaftaran->tanda_tanda_vital['tfu'], ['disabled' => 'disabled','class'=>'form-control','Placeholder'=>'TFU']) !!}
                      </div>
                    </div>

                    <div class="col-md-3">
                      <div class="form-group col-sm-11">
                        <label>IMT</label>
                        {!! Form::text('imt', $nomorAntrian->pendaftaran->tanda_tanda_vital['imt'], ['class'=>'form-control imt','Placeholder'=>'imt','readonly'=>'readonly']) !!}
                      </div>
                    </div>


                    <div class="col-md-3">
                      <div class="form-group col-sm-11">
                        <label>Status Alergi</label>
                        <div class="row">
                          <div class="col-sm-1" style="width:10px;">
                            <input type="checkbox" id = 'status_alergi' name="status_alergi" {{ $nomorAntrian->pendaftaran->status_alergi!=null?'checked':''}}>
                          </div>
                          <div class="col-sm-10">
                              {!! Form::text('status_alergi_value', $nomorAntrian->pendaftaran->status_alergi, [ 'id' => 'status_alergi_value', 'class'=>'form-control','Placeholder'=>'Status Alergi','disabled']) !!}
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group col-sm-11">
                        <label>Jenis Kasus</label>
                        {!! Form::select('jenis_kasus',['baru'=>'Jenis Kasus Baru','lama'=>'Jenis Kasus Lama'], $nomorAntrian->pendaftaran->tanda_tanda_vital['jenis_kasus'], ['disabled' => 'disabled','class'=>'form-control']) !!}
                      </div>
                    </div>
                  </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="box">
                <div class="box-body text-center">
                    <img src="https://img.pikbest.com/png-images/qiantu/cute-cartoon-little-girl-medical-patient-in-hospital-gown_2558435.png!c1024wm0/compress/true/progressive/true/format/webp/fw/1024" width="200">
                    <hr>
                    <table class="table table-bordered text-left">
                      <tr>
                        <td width="160">Nama Lengkap</td>
                        <td>{{$nomorAntrian->pendaftaran->pasien->nama}}</td>
                      </tr>
                      <tr>
                        <td>Nomor RM</td>
                        <td>{{$nomorAntrian->pendaftaran->pasien->nomor_rekam_medis}}</td>
                      </tr>
                      <tr>
                        <td>Tanggal Lahir</td>
                        <td>{{ $nomorAntrian->pendaftaran->pasien->tanggal_lahir }} / {{ hitung_umur($nomorAntrian->pendaftaran->pasien->tanggal_lahir) }} tahun</td>
                      </tr>
                    </table>
                </div>
            </div>
        </div>
        </div>
        @include('pendaftaran.pemeriksaan_klinis')
      {!! Form::close() !!}
      </section>
  </div>
@endsection