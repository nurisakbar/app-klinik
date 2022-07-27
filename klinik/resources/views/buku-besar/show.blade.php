@extends('layouts.app')
@section('title','Detail Buku Besar')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Detail Buku Besar
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
                          <h3>Nama Akun : {{ $akun->nama }}</h3>
                      </div>
                      <div class="col-md-4 text-center">
                          <h3>Periode : {{ date('F Y', strtotime($akun->jurnal[0]->tanggal)) }}</h3>
                      </div>
                      <div class="col-md-4 text-right">
                          <h3>Kode Akun : {{ $akun->kode }}</h3>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-12">
                          <table class="table table-striped text-center">
                              <thead>
                                  <tr>
                                      <th colspan="3">Transaksi</th>
                                      <th colspan="2">Saldo</th>
                                  </tr>
                                  <tr>
                                      <th>No</th>
                                      <th>Waktu Transaksi</th>
                                      <th>Keterangan</th>
                                      <th>Debet</th>
                                      <th>Kredit</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <?php 
                                  $jumlah_debet = 0;
                                  $jumlah_kredit = 0
                                  ?>
                                  @foreach($akun->jurnal as $jurnal)
                                  <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $jurnal->tanggal }}</td>
                                    <td>{{ $jurnal->keterangan }}</td>
                                    <td>{{ ($jurnal->tipe == 'debet' ? convert_rupiah($jurnal->nominal) : '-') }}</td>
                                    <td>{{ ($jurnal->tipe == 'kredit' ? convert_rupiah($jurnal->nominal) : '-') }}</td>
                                  </tr>
                                  <?php 

                                  if($jurnal->tipe == 'debet') {
                                      $jumlah_debet += $jurnal->nominal;

                                  } else {
                                      $jumlah_kredit += $jurnal->nominal;
                                  }
                                  ?>
                                  @endforeach
                              </tbody>
                              <tfoot>
                                  <tr>
                                      <th colspan="3">Jumlah</th>
                                      <th>{{ convert_rupiah($jumlah_debet) }}</th>
                                      <th>{{ convert_rupiah($jumlah_kredit) }}</th>
                                  </tr>
                                  <tr>
                                      <?php $saldo = $jumlah_debet - $jumlah_kredit?>
                                      <th colspan="3">Saldo</th>
                                      <th colspan="2">{{ convert_rupiah($saldo) }}</th>
                                  </tr>
                                  <tr>
                                      <th colspan="3">Terbilang</th>
                                      <th colspan="2">{{ terbilang($saldo) }}</th>
                                  </tr>
                              </tfoot>
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
