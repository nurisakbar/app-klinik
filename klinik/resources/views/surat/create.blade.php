@extends('layouts.app')
@section('title','Tambah Surat '.$jenis_surat)
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Form Surat
        <small>Tambah Surat Baru</small>
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
                  {!! Form::open(['url'=>'surat']) !!}
                  @include('validation_error')
                 <div class="row">
                     <div class="col-md-6">
                        <h3>Form Surat</h3>
                        <hr>
                        {{ Form::hidden('jenis_surat',$jenis_surat)}}
                        {{ Form::hidden('pendaftaran_id',$_GET['pendaftaran_id'])}}
                        <input type="hidden" name="dokter_id" value="{{ $nomorAntrian->dokter_id }}">
                        <table class="table table-bordered">
                            <tr>
                                <td width="200">Tekanan Darah</td>
                                <td>
                                    <input type="text" readonly="readonly" value="{{$pendaftaran->tanda_tanda_vital['tekanan_darah']}}" class="form-control">
                                </td>
                                <td width="200">Nadi</td>
                                <td><input type="text" readonly="readonly" value="{{$pendaftaran->tanda_tanda_vital['nadi']}}" class="form-control"></td>
                            </tr>
                            <tr>
                                <td>Tinggi Badan</td>
                                <td><input type="text" readonly="readonly" value="{{$pendaftaran->tanda_tanda_vital['tinggi_badan']}}" class="form-control"></td>
                                <td>Berat Badan</td>
                                <td><input type="text" readonly="readonly" value="{{$pendaftaran->tanda_tanda_vital['berat_badan']}}" class="form-control"></td>
                            </tr>
                            <tr>
                                <td>Suhu</td>
                                <td><input type="text" readonly="readonly" value="{{$pendaftaran->tanda_tanda_vital['suhu_tubuh']}}" class="form-control"></td>
                                <td>Pernafasan</td>
                                <td><input type="text" readonly="readonly" value="{{$pendaftaran->tanda_tanda_vital['pernafasan']??0}}" class="form-control"></td>

                            </tr>
                            <tr>
                                <td>Kesadaran</td>
                                <td><input type="text" readonly="readonly" value="{{$pendaftaran->tanda_tanda_vital['kesadaran']??0}}" class="form-control"></td>
                                <td>RR</td>
                                <td><input type="text" readonly="readonly" value="{{$pendaftaran->tanda_tanda_vital['rr']??0}}" class="form-control"></td>

                            </tr>
                            <tr>
                                <td>SPo2</td>
                                <td><input type="text" readonly="readonly" value="{{$pendaftaran->tanda_tanda_vital['saturasi_o2']??0}}" class="form-control"></td>
                            </tr>

                            @if($_GET['jenis']=='surat_sehat')
                                <tr>
                                    <td>Kesan</td>
                                    <td colspan="3">
                                        {{ Form::select('kesan',['Sakit'=>'Sakit','Tidak Sakit'=>'Tidak Sakit'],null,['class'=>'form-control'])}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Keperluan</td>
                                    <td colspan="3"><input type="text" name="keperluan" placeholder="Keterangan" required="required" class="form-control"></td>
                                </tr>
                            @elseif($_GET['jenis']=='surat_rujukan')
                                <tr>
                                    <td>Lain Lain</td>
                                    <td colspan="3">
                                        {{ Form::text('lain_lain',null,['class'=>'form-control','placeholder'=>'Lain Lain'])}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Diagnosa Sementara</td>
                                    <td colspan="3"><input type="text" name="diagnosa_sementara" placeholder="Diagnosa Sementara" required="required" class="form-control"></td>
                                </tr>
                                <tr>
                                    <td>Tindakan Yang Telah Dilakukan</td>
                                    <td colspan="3"><input type="text" name="tindakan_yang_telah_dilakukan" placeholder="Tindakan Yang Telah Dilakukan" required="required" class="form-control"></td>
                                </tr>
                                <tr>
                                    <td>Terapi Yang Telah Diberikan</td>
                                    <td  colspan="3"><input type="text" name="terapi_yang_telah_diberikan" placeholder="Terapi Yang Telah Diberikan" required="required" class="form-control"></td>
                                </tr>
                                <tr>
                                    <td>Spesialis</td>
                                    <?php
                                    $user = \DB::table('users')->where('role','dokter')->where('id',session('user_id'))->first();
                                    ?>
                                    <td  colspan="3"><input type="text" name="spesialis" placeholder="Spesialis" required="required" class="form-control"></td>
                                </tr>
                                <tr>
                                    <td>Faskes Tujuan</td>
                                    <td colspan="3">
                                        {{ Form::text('faskes_tujuan',null,['class'=>'form-control','placeholder'=>'Faskes Tujuan Rurukan'])}}
                                    </td>
                                </tr>
                            @elseif($_GET['jenis']=='surat_sakit')
                            <tr>
                                <td>Instansi</td>
                                <td  colspan="3"><input type="text" name="instansi" placeholder="Instansi" required="required" class="form-control"></td>
                            </tr>
                            <tr>
                                <td>Dari Tanggal  - Sampai Tanggal</td>
                                <td colspan="3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="date" name="dari_tanggal" placeholder="Dari Tanggal" required="required" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="date" name="sampai_tanggal" placeholder="Sampai Tanggal" required="required" class="form-control">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Diganosa</td>
                                <td  colspan="3"><input type="text" name="diagnosa_sementara" placeholder="Diganosa" required="required" class="form-control"></td>
                            </tr>
                            @else
                                <tr>
                                    <td>Hasil Pemeriksaan</td>
                                    <td colspan="3">
                                        <input type="radio" name="hasil_pemeriksaan_mata" value="Buta Warna"> Buta Warna<br>
                                        <input type="radio" name="hasil_pemeriksaan_mata" value="Tidak Buta Warna"> Tidak Buta Warna

                                    </td>
                                </tr>
                                <tr>
                                    <td>Saran</td>
                                    <td  colspan="3"><input type="text" name="saran" placeholder="Saran" required="required" class="form-control"></td>
                                </tr>
                                <tr>
                                    <td>Untuk Keperluan</td>
                                    <td colspan="3"><input type="text" name="keperluan" placeholder="Untuk Keperluan" required="required" class="form-control"></td>
                                </tr>
                            @endif
                            <tr>
                                <td></td>
                                <td>
                                    <button type="submit" class="btn btn-danger">Simpan Dan Cetak</button>
                                </td>
                            </tr>
                        </table>
                     </div>
                     <div class="col-md-6">
                         <h3>Data Pasien</h3>
                         <hr>

                  <table class="table table-bordered">
                    <tr>
                      <td rowspan="7">
                        <img src="data:image/png;base64,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">
                      </td>
                    </tr>
                    <tr>
                      <td>Nomor Rekamedis</td>
                      <td>{{ $pendaftaran->pasien->nomor_rekam_medis }}</td>
                    </tr>
                    <tr>
                      <td>Nama</td>
                      <td>{{ $pendaftaran->pasien->nama }}</td>
                    </tr>
                    <tr>
                      <td>Tempat, Tgl Lhr</td>
                      <td>{{ $pendaftaran->pasien->tempat_lahir }}, {{ $pendaftaran->pasien->tanggal_lahir }}</td>
                    </tr>
                    <tr>
                      <td>Umur</td>
                      <td>{{ hitung_umur($pendaftaran->pasien->tanggal_lahir) }} Tahun</td>
                    </tr>
                    <tr>
                      <td>Jenis Layanan</td>
                      <td>Pasien {{ $pendaftaran->perusahaanAsuransi->nama_perusahaan }}</td>
                    </tr>
                  </table>
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
