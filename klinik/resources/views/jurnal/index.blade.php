@extends('layouts.app')
@section('title','Kelola Jurnal Umum')
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Kelola Data Jurnal Umum
      <small>Daftar Jurnal Umum</small>
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
            {{ Form::open(['url'=>'jurnal','method'=>'GET']) }}
            <table class="table table-bordered">
              <tr>
                <td width="200">Pilih Akun</td>
                <td>
                  <div class="row">
                    <div class="col-md-4">
                      {{ Form::select('akun_id',$akunList,$_GET['akun_id']??null,['class' => 'form-control','placeholder'=>'-- Semua Akun --']) }}
                    </div>
                  </div>
                  
                </td>
              </tr>
              <tr>
                <td>Periode</td>
                <td>
                  <div class="row">
                    <div class="col-md-2">
                      {{ Form::date('tanggal_awal',$tanggal_awal,['class' => 'form-control','placeholder'=>'Periode Awal'])}}
                    </div>
                    <div class="col-md-2">
                      {{ Form::date('tanggal_akhir',$tanggal_akhir,['class' => 'form-control','placeholder'=>'Periode Awal'])}}
                    </div>
                  </div>
                </td>
              </tr>
              <tr>
                <td></td>
                <td>
                  <button class="btn btn-info btn-social btn-flat" type="submit"><i class="fa fa-gear" aria-hidden="true"></i> Filter Data</button>
                    <button class="btn btn-success btn-social btn-flat" type="submit"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Dowload Excel</button>
                    <a href="{{route('jurnal.create')}}" class="btn btn-info btn-social btn-flat"><i class="fa fa-plus-square-o" aria-hidden="true"></i>
                      Tambah Data</a>
                </td>
              </tr>
            </table>
            {{ Form::close() }}
            <hr>
            @include('alert')
            <table class="table table-bordered table-striped" id="jurnals-table">
              <thead>
                <tr>
                  <th width="10">Tanggal</th>
                  <th>Akun</th>
                  <th>Reff</th>
                  <th>Keterangan</th>
                  <th>Debet</th>
                  <th>Kredit</th>
                  <th width="60">#</th>
                </tr>
              </thead>
              <tbody>
                @foreach($periode as $tanggal)
                <tr>
                  <td>{{ $tanggal->tanggal}}</td>
                  <td>
                    @foreach(\App\Models\Jurnal::where('tanggal',$tanggal->tanggal)->get() as $jurnal)
                    {{ $jurnal->akun->nama}}<br>
                    @endforeach
                  </td>
                  <td>
                    @foreach(\App\Models\Jurnal::where('tanggal',$tanggal->tanggal)->get() as $jurnal)
                    {{ $jurnal->akun->kode}}<br>
                    @endforeach
                  </td>
                  <td>
                    @foreach(\App\Models\Jurnal::where('tanggal',$tanggal->tanggal)->get() as $jurnal)
                      {{ $jurnal->keterangan}}<br>
                    @endforeach
                  </td>
                  <td>
                    @foreach(\App\Models\Jurnal::where('tanggal',$tanggal->tanggal)->get() as $jurnal)
                        @if($jurnal->tipe=='debet')
                        {{ rupiah($jurnal->nominal)}}<br>
                      @else
                        -<br>
                      @endif
                    @endforeach
                  </td>
                  <td>
                    @foreach(\App\Models\Jurnal::where('tanggal',$tanggal->tanggal)->get() as $jurnal)
                        @if($jurnal->tipe=='kredit')
                        {{ rupiah($jurnal->nominal)}}<br>
                      @else
                        -<br>
                      @endif
                    @endforeach
                  </td>
                  <td>
                    @foreach(\App\Models\Jurnal::where('tanggal',$tanggal->tanggal)->get() as $jurnal)
                    <?php
                    $btn = \Form::open(['url' => 'jurnal/' . $jurnal->id, 'method' => 'DELETE', 'style' => 'float:right;margin-right:5px']);
                    $btn .= "<button type='submit' class='btn btn-danger btn-sm'><i class='fa fa-trash' aria-hidden='true'></i></button>";
                    $btn .= \Form::close();
                    echo $btn;  
                    ?>
                    <a class="btn btn-danger btn-sm" href="/jurnal/{{$jurnal->id}}/edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                    @endforeach
                  </td>
                </tr>                
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection

@push('scripts')
<!-- DataTables -->
<script src="{{asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script>
  $(function() {
    $('#jurnals-table').DataTable();
  });
</script>
@endpush

@push('css')
<link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
@endpush