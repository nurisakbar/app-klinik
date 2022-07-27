@extends('layouts.app')
@section('title','Form pembayaran')
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Form Pembayaran
      <small></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>


  <section class="content">
    <div class="row">
      <div class="col-xs-7">
        <div class="box">

          <div class="box-body">
            <hr>
            @include('alert')
            <h2 class="text-center"><b>Informasi Pasien</b></h2>
            <table class="table table-striped" id="pegawai-table">
              <thead>
                <tr>
                  <td width="300">Nomor KTP</td>
                  <td width="20">:</td>
                  <th>{{ $nomorAntrian->pendaftaran->pasien->nomor_ktp }}</th>
                </tr>
                <tr>
                    <td>Nama Pasien</td>
                    <td>:</td>
                    <th>{{ $nomorAntrian->pendaftaran->pasien->nama }}</th>
                </tr>
                <tr>
                    <td>Penjamin</td>
                    <td>:</td>
                    <th>{{ $nomorAntrian->perusahaanAsuransi->nama_perusahaan }}</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
        <div class="box">
            <div class="box-body">
              <div class="alert alert-info" role="alert">
                Klik Button Refresh Disamping Kolom Total Jika Anda Melakukan Perubahan Pada Kolom Diskon
              </div>

                <h2 class="text-center"><strong>Detail Pembayaran</strong></h2>
                <table class="table table-bordered">
                  <tr style="background-color :#222d32 ;color:#ffffff;">
                    <th width="10">No</th>
                    <th>Detail Layanan</th>
                    <th>Jumlah</th>
                    <th width="100">Biaya</th>
                    <th>Diskon</th>
                    <th>Subtotal</th>
                    <th>Keterangan</th>
                    <th width="10"></th>
                  </tr>
                  <tr class="success">
                    <th colspan="7">Biaya Tindakan</th>
                  </tr>
                  @php $jumlah = 0; $nomor = 1 @endphp
                  @foreach(\App\Models\PendaftaranTindakan::where('pendaftaran_id',$nomorAntrian->pendaftaran->id)
                  ->where('poliklinik_id',$nomorAntrian->poliklinik_id)
                  ->get() as $row)

                  <?php
                  // hitung FEE Tindakan
                  if($nomorAntrian->perusahaanAsuransi->nama_perusahaan=='BPJS' && $row->tindakan->pelayanan=='bpjs'){
                    $feeTindakan = 0;
                    $keterangan = "BPJS";
                  }else{
                    $feeTindakan = $row->fee;
                    $keterangan  = "-";
                  }
                  ?>
                    <tr>
                      <td>{{$nomor}}</td>
                      <td>{{$row->tindakan->tindakan}}</td>
                      <td>{{$row->qty}}</td>
                      <td style="text-align:right">{{rupiah($feeTindakan)}}</td>
                      <td><input value="{{$row->discount}}" style="width:70px" type="text" class="form-control tindakan_{{$row->id}}" onKeyup="updateDiskonTindakan({{$row->id}})"></td>
                      <td>{{rupiah(($feeTindakan*$row->qty)-$row->discount)}}</td>
                      <td>{{ $keterangan }}</td>
                      <td>
                        <button type="button" class="btn btn-danger btn-sm"><i class='fa fa-trash' aria-hidden='true'></i></button>
                      </td>
                    </tr>
                    @php 
                    $jumlah += ($feeTindakan*$row->qty)-$row->discount; 
                    $nomor++ @endphp
                  @endforeach


                  <tr class="success">
                    <th colspan="7">Biaya Obat Racik</th>
                  </tr>
                  @foreach(\App\Models\PendaftaranObatRacik::with('detail')
                  ->where('pendaftaran_id',$nomorAntrian->pendaftaran->id)
                  ->where('poliklinik_id',$nomorAntrian->poliklinik->id)
                  ->get() as $racikItem)
                    @foreach ($racikItem->detail as $item)
                    <?php
                    if($nomorAntrian->perusahaanAsuransi->nama_perusahaan=='BPJS' && $item->barang->pelayanan=='bpjs'){
                    $hargaObatRacik = 0;
                    $keterangan = "BPJS";
                  }else{
                    $hargaObatRacik = $item->harga;
                    $keterangan  = "-";
                  }
                    ?>
                    <tr>
                      <td>{{$nomor}}</td>
                      <td>{{$item->barang->nama_barang}}</td>
                      <td>{{ $item->jumlah }}</td>
                      <td style="text-align:right">{{rupiah(($hargaObatRacik*$item->jumlah))}}</td>
                      <td>0</td>
                      <td>{{ rupiah($item->jumlah*$hargaObatRacik) }}</td>
                      <td>{{ $keterangan }}</td>
                    </tr>
                    @php 
                    $jumlah += $hargaObatRacik*$item->jumlah; 
                    $nomor++ @endphp
                    @endforeach
                @endforeach
                <tr class="success">
                  <th colspan="7">Biaya Obat Non Racik</th>
                </tr>
                @foreach(\App\Models\PendaftaranResep::with('barang')
                ->where('jenis','non racik')
                ->where('pendaftaran_id',$nomorAntrian->pendaftaran->id)
                ->where('poliklinik_id',$nomorAntrian->poliklinik->id)
                ->get() as $row)
                <?php
                  if($nomorAntrian->perusahaanAsuransi->nama_perusahaan=='BPJS' && $row->barang->pelayanan=='bpjs'){
                  $hargaObatNonRacik = 0;
                  $keterangan = "BPJS";
                }else{
                  $hargaObatNonRacik = $row->harga;
                  $keterangan  = "-";
                }
                  ?>

                  <tr class="obat_non_racik_{{ $row->id}}">
                    <td>{{$nomor}}</td>
                    <td>{{$row->barang->nama_barang}} ( {{$row->satuan}} {{$row->aturan_pakai}}) </td>
                    <td>{{$row->jumlah}}</td>
                     <td style="text-align:right">{{ rupiah($hargaObatNonRacik)}}</td>
       
                    <td>0</td>
                    <td style="text-align:left">{{ rupiah($hargaObatNonRacik*$row->jumlah)}}</td>
                    <td>{{ $keterangan }}</td>
                    <td>
                      <button type="button" onClick="hapusObatNonRacik({{$row->id}})" class="btn btn-danger btn-sm"><i class='fa fa-trash' aria-hidden='true'></i></button>
                    </td>
                  </tr>
                  @php $jumlah += $hargaObatNonRacik*$row->jumlah ; $nomor++ @endphp
                @endforeach

              @if($nomorAntrian->poliklinik_id!=7)
                <tr class="success">
                  <th colspan="7">Biaya BHP </th>
                </tr>
                  @foreach(\App\Models\PendaftaranResep::with('barang')
                  ->where('jenis','bhp')->where('pendaftaran_id',$nomorAntrian->pendaftaran->id)
                  ->where('poliklinik_id',$nomorAntrian->poliklinik->id)
                  ->get() as $row)
                  <?php
                    if($nomorAntrian->perusahaanAsuransi->nama_perusahaan=='BPJS' && $row->barang->pelayanan=='bpjs'){
                    $hargaObatNonRacik = 0;
                    $keterangan = "BPJS";
                  }else{
                    $hargaObatNonRacik = $row->harga;
                    $keterangan  = "-";
                  }
                    ?>

                    <tr class="item_bhp_{{ $row->id}}">
                      <td>{{$nomor}}</td>
                      <td>{{$row->barang->nama_barang}} ( {{$row->satuan}} {{$row->aturan_pakai}}) </td>
                      <td>{{$row->jumlah}}</td>
                       <td style="text-align:right">{{ rupiah($hargaObatNonRacik)}}</td>
         
                      <td>0</td>
                      <td style="text-align:left">{{ rupiah($hargaObatNonRacik*$row->jumlah)}}</td>
                      <td>{{ $keterangan }}</td>
                      <td>
                        <button type="button" onClick="hapusBHP({{$row->id}})" class="btn btn-danger btn-sm"><i class='fa fa-trash' aria-hidden='true'></i></button>
                      </td>
                    </tr>
                    @php $jumlah += $hargaObatNonRacik*$row->jumlah ; $nomor++ @endphp
                  @endforeach
              @endif
                  <tr style="text-align:right" style="font-weight: bold">
                    <td colspan=5>Total Pembayaran</td>
                    <td colspan="1" style="text-align:left">
                      {{rupiah($jumlah)}}
                      <input type="hidden" class="total_bayar" value="{{$jumlah}}">
                    </td>
                    <td>
                      <button title="Refresh Halaman Untuk Menampilkan Data Terbaru" onclick="reloadPage()" type="button" class="btn btn-danger"><i class="fa fa-refresh" aria-hidden="true"></i></button>
                    </td>
                  </tr>
                </table>
            </div>
        </div>

      </div>
      <div class="col-xs-5">
        <div class="box">
          <div class="box-body">
              <h2 class="text-center"><strong>Pembayaran</strong></h2>
              {!! Form::open(['url'=>"pembayaran/$nomorAntrian->id/store",'class'=>'form-horizontal']) !!}
              @include('validation_error')
              @include('pembayaran.form')
              {!! Form::close() !!}
          </div>
      </div>
      </div>
    </div>
  </section>
</div>
@endsection

@push('scripts')
<script>
  $(function() {
    console.log('ok');
    $("#total_bayar").val($(".total_bayar").val());
  });


  function hapusBHP(id){
    console.log(id);
    $.ajax({
      url: "/pendaftaran-resep/"+id,
      data: {"_token": "{{ csrf_token() }}"},
      method: 'DELETE',
      success: function (response) {
        //console.log(response);
        location.reload();
        }
      });
  }

  function hitung_kembalian(){
      var total_bayar = $(".total_bayar").val();
      var jumlah_bayar = $(".jumlah_bayar").val();
      var biaya_tambahan = $(".biaya_tambahan").val();
      $('.kembalian').val(total_bayar-(jumlah_bayar-biaya_tambahan));
    }

    function hapusTindakan(id){
      $.ajax({
      url: "/pendaftaran-tindakan/"+id,
      data: {"_token": "{{ csrf_token() }}"},
      method: 'DELETE',
      success: function (response) {
        location.reload();
        }
      });
    }


    function updateDiskonTindakan(id){
      var diskon = $(".tindakan_"+id).val();
      $.ajax({
        url: "/ajax/update-diskon-tindakan/",
        data: {"_token": "{{ csrf_token() }}",discount:diskon,id:id},
        method: 'POST',
        success: function (response) {
          console.log(response)
          }
      });
    }

    function reloadPage(){
      location.reload();
    }

    function hapusObatNonRacik(id){
      console.log(id);
      $.ajax({
      url: "/pendaftaran-resep/"+id,
      data: {"_token": "{{ csrf_token() }}"},
      method: 'DELETE',
      success: function (response) {
        location.reload();
        }
      });
    }
</script>
@endpush
