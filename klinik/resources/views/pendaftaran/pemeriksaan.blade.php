@extends('layouts.app')
@section('title',"Pendaftaran ".$nomorAntrian->pendaftaran->kode)
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Pendaftaran
        <small>{{ $nomorAntrian->pendaftaran->kode }} </small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <section class="content">
        <div class="row">
          <div class="col-xs-6">
            <div class="box">
              <div class="box-body">
                  <h4>Biodata Pasien</h4>
                  <hr>

                  <table class="table table-bordered">
                    <tr>
                      <td rowspan="7">
                        <img src="data:image/png;base64,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">
                      </td>
                    </tr>
                    <tr>
                      <td>Nomor Rekamedis</td>
                      <td>{{ $nomorAntrian->pendaftaran->pasien->nomor_rekam_medis }}</td>
                    </tr>
                    <tr>
                      <td>Nama</td>
                      <td>{{ $nomorAntrian->pendaftaran->pasien->nama }}</td>
                    </tr>
                    <tr>
                      <td>Tempat, Tgl Lhr</td>
                      <td>{{ $nomorAntrian->pendaftaran->pasien->tempat_lahir }}, {{ $nomorAntrian->pendaftaran->pasien->tanggal_lahir }}</td>
                    </tr>
                    <tr>
                      <td>Umur</td>
                      <td>{{ hitung_umur($nomorAntrian->pendaftaran->pasien->tanggal_lahir) }} Tahun</td>
                    </tr>
                    <tr>
                      <td>Jenis Layanan</td>
                      <td>Pasien {{ $nomorAntrian->pendaftaran->perusahaanAsuransi->nama_perusahaan }}</td>
                    </tr>
                  </table>

                  <h4>Daftar Kunjungan</h4>
                  <table class="table table-bordered">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Penjamin</th>
                        <th>Poliklinik</th>
                        <th width="30"></th>
                    </tr>
                    @if(count($riwayatKunjungan)>0)
                      @foreach($riwayatKunjungan as $riwayat)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ tgl_indo($riwayat->tanggal_kunjungan) }}</td>
                          <td>{{ $riwayat->perusahaan_penjamin }}</td>
                          <td>{{ $riwayat->poliklinik }}</td>
                          <td>
                            <button type="button" data-kode="{{ $riwayat->id }}" class="btn btn-primary btn-sm kode" data-toggle="modal" data-target="#modalHistoryPendaftaran">
                              <i class='fa fa-eye' aria-hidden='true'></i>
                            </button>
          
                          </td>
                        </tr>
                      @endforeach
                    @else
                        <tr style="text-align:center">
                          <td colspan="5">Belum Ada Data</td>
                        </tr>
                    @endif
                </table>
                  <hr>

                  <a href="/pendaftaran/{{ $nomorAntrian->id }}/selesai" class="btn btn-danger btn-lg btn-selesai">Tandai Selesai Pelayanan</a>
                  {{-- <a href="/pendaftaran/{{ $nomorAntrian->pendaftaran->id }}/cetak_rekamedis" target="new" class="btn btn-danger btn-lg">Cetak Rekamedis</a> --}}
                  <div class="btn-group">
                    <button type="button" class="btn btn-danger btn-lg btn-surat">Cetak Surat</button>
                    <button type="button" class="btn-surat btn btn-danger btn-lg dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                    <li><a href="/surat/create?jenis=surat_sakit&pendaftaran_id={{$nomorAntrian->pendaftaran->id}}">Surat Keterangan Sakit</a></li>
                    <li><a href="/surat/create?jenis=surat_sehat&pendaftaran_id={{$nomorAntrian->pendaftaran->id}}">Surat Keterangan Sehat</a></li>
                    <li><a href="/surat/create?jenis=surat_rujukan&pendaftaran_id={{$nomorAntrian->pendaftaran->id}}">Surat Rujukan</a></li>
                    <li><a href="/surat/create?jenis=surat_buta_warna&pendaftaran_id={{$nomorAntrian->pendaftaran->id}}">Surat Keterangan Buta Warna</a></li>
                    </ul>
                    </div>
                  <a href="/pendaftaran" class="btn btn-danger btn-lg">Kembali</a>
              </div>
            </div>
          </div>
          <div class="col-xs-6">
            <div class="box">
              <div class="box-body">
                <h4>Input Anamnesa</h4>
                <hr>
                <textarea class="form-control anamnesa" onKeyUp="simpan_anamnesa()" placeholder="Anamnesa Pasien">{{ $nomorAntrian->anamnesa }}</textarea>
                <hr style="border:1px dashed">
                @if(Auth::user()->poliklinik_id == env("POLI_TUMBUH_KEMBANG_ID", "somedefaultvalue"))
               
                <h4>Catatan Harian <button style="float: right" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-catatan-harian">
                  Input Catatan Harian
                </button></h4>
                <hr>
                <div id="catatan_harian"></div>
                <hr style="border:1px dashed">
              
                  <h4>Daftar Tindakan <button style="float: right" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
                    Input Tindakan
                  </button></h4>
                  <hr>

                  <div id="daftar_tindakan"></div>
                  <hr style="border:1px dashed">
                  <h4>Daftar Diagnosa <button style="float: right" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-diagnosa">
                    Input Diganosa
                  </button></h4>
                  <hr>
                  <div id="daftar_diagnosa"></div>
                 @else
                 <h4>Daftar Tindakan <button style="float: right" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
                  Input Tindakan
                </button></h4>
                <hr>

                <div id="daftar_tindakan"></div>
                <hr style="border:1px dashed">
                <h4>Daftar Diagnosa <button style="float: right" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-diagnosa">
                  Input Diganosa
                </button></h4>
                <hr>
                <div id="daftar_diagnosa"></div>
                  <hr style="border:1px dashed">
                  <h4>Daftar Obat Non Racik <button style="float: right" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-obat-non-racik">
                    Input Obat Non Racik
                  </button></h4>
                  <hr>

                  <div id="daftar_obat_racik"></div>
                  <h4>Daftar Obat Racik <button style="float: right" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-obat-racik">
                    Input Obat Racik
                  </button></h4>
                  <hr>

                  <div id="daftar_obat_non_racik"></div>


                  <hr style="border:1px dashed">
                  <h4>Rujukan Internal <button style="float: right" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-rujukan-laporatorium">
                    Input Rujukan
                  </button></h4>
                  <hr>
                  <div id="rujukan_internal"></div>
                  @endif
              </div>
            </div>
          </div>
        </div>
      </section>
  </div>


    <!-- Modal Tindakan -->
<div class="modal fade" id="modal-catatan-harian" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Form Input Catatan Harian</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-bordered">
          <tr>
            <td>Tanggal</td>
            <td>
              <input type="date" name="tanggal" class="form-control tanggal_txt" placeholder="Tanggal">
            </td>
          </tr>
          <tr>
            <td>Catatan</td>
            <td>
              {!! Form::textarea('catatan_harian', null, ['class'=>'form-control catatan', 'placeholder'=>'Catatan Harian']) !!}
            </td>
          </tr>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary" onClick="simpan_catatan_harian()">Simpan</button>
      </div>
    </div>
  </div>
</div>



  <!-- Modal Tindakan -->
<div class="modal fade" id="exampleModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Form Input Tindakan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <table class="table table-bordered table-bordered">
            <tr>
              <td width="200">Tindakan</td>
              <td>
                <select style="width: 100%" name="tindakan_id" id="tindakan_id" class='select2 form-control'>
                </select>
                
              </td>
            </tr>
            <tr>
              <td>Dokter</td>
              <td>
                {!! Form::select('dokter', $dokter1, session('user_id'), ['class'=>'form-control', 'id' => 'dokter']) !!}
              </td>
            </tr>
            <tr>
              <td>Asistensi</td>
              <td>
                {!! Form::select('asisten', $dokter2, null, ['class'=>'form-control', 'id' => 'asisten','placeholder'=>'-- Tidak Ada --']) !!}
              </td>
            </tr>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          <button type="button" class="btn btn-primary" onClick="simpan_daftar_tindakan()">Simpan</button>
        </div>
      </div>
    </div>
  </div>

<!-- Modal Obat Non Racik -->
<div class="modal fade" id="modal-obat-non-racik" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Form Input Obat Non Racik</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <table class="table table-bordered table-bordered">
              <tr>
                <td>Pilih Barang</td>
                <td>
                  <div class="row">
                    <div class="col-md-7">
                      <select name="barang_id" id="barang_id" class='form-control' style="width:100%">
                      </select>
                      
                    </div>
                    {{-- <div class="col-md-5">
                      <input type="checkbox" onclick="check_lock_bpjs()" {{ $nomorAntrian->pendaftaran->perusahaanAsuransi->nama_perusahaan=='BPJS'?'checked=checked"':''}} id="lock_bpjs"> Kunci Obat Umum ? </div>
                  </div> --}}
                 
                </td>
              </tr>
              <tr>
                <td>Jumlah & Satuan</td>
                <td>
                  <div class="row">
                    <div class="col-md-6">
                      <input type="number" name="jumlah" id="jumlah" class="form-control" placeholder="Masukan jumlah obat">
                    </div>
                    <div class="col-md-6">
                      {{ Form::select('satuan',$satuan,null,['class' => 'form-control obat_non_racik_satuan','id'=>'satuan']) }}
                    </div>
                  </div>
                </td>
              </tr>
              <tr>
                <td>Aturan Pakai</td>
                <td>
                  <input type="text" id="aturan_pakai" placeholder="Aturan Pakai" class="form-control">
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary" onClick="simpan_daftar_obat_non_racik()">Simpan</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Obat Non Racik -->
<div class="modal fade" id="modal-obat-racik" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Form Input Obat Racik</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">

            {{ Form::open(['url'=>'pendaftaran-resep-racik']) }}
            {{ Form::hidden('pendaftaran_id',$nomorAntrian->pendaftaran->id) }}
            {{ Form::hidden('poliklinik_id',$nomorAntrian->poliklinik_id) }}
            {{ Form::hidden('nomor_antrian_id',$nomorAntrian->id) }}
            <table class="table table-bordered inner2 form-racik-1101">
              <tr>
                <th>Jumlah Kemasan</th>
                <th>Jenis Kemasan</th>
                <th>Aturan Pakai  
                  <button type="button" class="btn btn-sm btn-danger" style="float: right" onClick="add_obat_racik()">
                  <i class="fa fa-plus-square" aria-hidden="true"></i>
                </button></th>
              </tr>
              <tr>
                <td>
                  {{ Form::text('jumlah_kemasan[1][]',null,['class'=>'form-control','placeholder'=>'Jumlah Kemasan','required'=>'required'])}}
                </td>
                <td>
                  {{ Form::select('jenis_kemasan[1][]',$satuan,null,['class'=>'form-control','placeholder'=>'Pilih'])}}
                </td>
                <td>
                  {{ Form::text('aturan_pakai[1][]',null,['class'=>'form-control','placeholder'=>'Aturan Pakai','required'=>'required'])}}
                </td>
              </tr>
              <tr>
                <th colspan="3">Komposisi Obat</th>
              </tr>
              <tr class="inner-1">
                <td colspan="2">
                  <select name="barang_id[1][]" class='form-control barang_id_txt' required style="width:100%">
                </td>
                <td>
                 
                  <div class="row">
                    <div class="col-md-5">
                      {{ Form::text('jumlah[1][]',null,['class'=>'form-control','placeholder'=>'Jumlah','required'=>'required'])}}
                    </div>
                    <div class="col-md-5">
                      <button type="button" class="btn btn-sm btn-danger" onClick="add_komposisi(1)">
                        <i class="fa fa-plus-square" aria-hidden="true"></i>
                      </button>
                    </div>
                  </div>
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
      {{ Form::close()}}
    </div>
  </div>
</div>

  <!-- Modal Diagnosa -->
<div class="modal fade" id="modal-diagnosa" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Form Input Diagnosa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <table class="table table-bordered table-bordered">
              <tr>
                <td width="200">Pilih Diagnosa</td>
                <td>
                  <select name="diagnosa_id" id="diagnosa_id" class='select2 form-control' style="width: 100%">
                  </select>
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary" onClick="simpan_daftar_diagnosa()">Simpan</button>
      </div>
    </div>
  </div>
</div>


  <!-- Rujukan Internal -->
  <div class="modal fade" id="modal-rujukan-laporatorium" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Rujukan Internal</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <table class="table table-bordered table-bordered">
                <tr>
                  <td width="200">Pilih Unit</td>
                  <td> 
                    {{ Form::select('poliklinik_id',$poliklinik1,null,['class'=>'form-control poliklinik_id','onChange'=>'filter_rujukan_tindakan()'])}}
                  </td>
                </tr>
                <tr>
                  <td width="200">Dokter Perujuk</td>
                  <td>
                    {{ Form::select('user_id',$dokter1,session('user_id'),['class'=>'form-control user_id'])}}
                  </td>
                </tr>
                <tr>
                  <td width="200">Jenis Pemeriksaan ( Opsional )</td>
                  <td>
                    <div class="row">
                      <div class="col-md-9">
                        <select style="width: 100%" name="jenis_pemeriksaan_laboratorium_id" id="tindakan_id_rujukan" class='select2 form-control jenis_pemeriksaan_laboratorium_id'>
                        </select>
                      </div>
                      <div class="col-md-3">
                        <button class="btn btn-danger btn-sm" onclick="tambahTindakanLab()"><i  class="fa fa-plus-square fa-2" aria-hidden="true"></i>
                        </button>
                      </div>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>Catatan</td>
                  <td>
                    {{ Form::text('catatan',null,['class'=>'form-control catatan_rujukan_internal','placeholder'=>'Catatan'])}}
                  </td>
                </tr>

              </table>

              <div id="tindakan-temp"></div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary btn-simpan-rujukan" onClick="simpan_daftar_rujukan()">Simpan</button>
        </div>
      </div>
    </div>
  </div>


  <!-- Modal custom  -->
<div class="modal fade" id="myModalCustomBHP" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Tambahkan BHP</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-9">
            <input type="hidden" class="txt_pendaftaran_tindakan_id" value="">
            <select name="barang_id_txt" id="barang_id_txt_bhp" class='form-control' style="width:100%">
            </select>
          </div>
          <div class="col-md-3">
            <input type="text" id="bhp_qty_txt" class="form-control" placeholder="Qty">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary" onClick="simpan_bhp_tambahan()">Simpan</button>
      </div>
    </div>
  </div>
</div>

  <!-- Modal history pendafatran -->
<div class="modal fade" id="modalHistoryPendaftaran" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Riwayat Pelayanan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <div id="hasil_riwayat"></div>
        </div>
        <div class="modal-footer">
          <a id="resume-medis" class="btn btn-danger" target="new">Cetak</a>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
@endsection


@push('scripts')
{{-- <script src="{{asset('adminlte/bower_components/select2/dist/js/select2.min.js')}}"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script>
  $(document).ready(function(){
    $('.barang').select2();
    load_daftar_tindakan();
    load_daftar_diagnosa();
    load_daftar_obat_racik();
    load_daftar_obat_non_racik();
    load_rujukan_internal()
    load_catatan_harian();
    checkTindakanKetikaRujukan();

    check_anamnesa();

    $( "#modal-obat-non-racik").on('shown.bs.modal', function(){
      $("#barang_id").val('');
      $("#jumlah").val('');
      $("#aturan_pakai").val('');
    });


    $( "#modal-rujukan-laporatorium" ).on('shown.bs.modal', function (e) {
    filter_rujukan_tindakan();
    });
    

    $('#tindakan_id').select2({
      placeholder: 'Cari tindakan',
      multiple: false,
      ajax: {
        url: '/ajax/select2Tindakan?poliklinik_id='+{{ Auth::user()->poliklinik_id }},
        dataType: 'json',
        delay: 250,
        multiple: false,
        processResults: function(data) {
          return {
            results: $.map(data, function(item) {
              return {
                text: item.tindakan,
                id: item.id
              }
            })
          };
        },
        cache: true
      }
    });

    $('#tindakan_id_rujukan').select2({
      placeholder: 'Cari tindakan',
      multiple: false,
      ajax: {
        //url: '/ajax/select2Tindakan?poliklinik_id='+$(".poliklinik_id").val(),
        url: '/ajax/select2Tindakan',
        dataType: 'json',
        delay: 250,
        multiple: false,
        processResults: function(data) {
          return {
            results: $.map(data, function(item) {
              return {
                text: item.tindakan,
                id: item.id
              }
            })
          };
        },
        cache: true
      }
    });


    $('#barang_id').select2({
    placeholder: 'Cari Barang',
    tags: false,
    ajax: {
      url: '/ajax/select2Barang?pelayanan={{ $nomorAntrian->perusahaanAsuransi->nama_perusahaan}}&poliklinik_id='+{{ Auth::user()->poliklinik_id }},
      dataType: 'json',
      delay: 250,
      processResults: function(data) {
        return {
          results: $.map(data, function(item) {
            console.log(item);
            return {
              text: item.nama_barang,
              harga: item.harga,
              id: item.id
            }
          })
        };
      },
      cache: true
    }
  });

  $('#barang_id_txt_bhp').select2({
    placeholder: 'Cari Barang',
    tags: false,
    ajax: {
      url: '/ajax/select2Barang?pelayanan={{ $nomorAntrian->perusahaanAsuransi->nama_perusahaan}}&poliklinik_id='+{{ Auth::user()->poliklinik_id }},
      dataType: 'json',
      delay: 250,
      processResults: function(data) {
        return {
          results: $.map(data, function(item) {
            console.log(item);
            return {
              text: item.nama_barang,
              harga: item.harga,
              id: item.id
            }
          })
        };
      },
      cache: true
    }
  });


  $('#barang_id').on('change', function (evt) {
  if ($('#barang_id').select2('val') != null){
    var barang_id = $('#barang_id').select2('data')[0]['id'];
    $.ajax({
      url: "/barang/"+barang_id,
      type: "GET", //send it through get method
      success: function(response) {
        $(".obat_non_racik_satuan").val(response.satuan_terkecil_id).change();
      },
      error: function(xhr) {
        //Do Something to handle error
      }
    });
    
  }
});



  $('.barang_id_txt').select2({
    placeholder: 'Cari Barang',
    tags: false,
    ajax: {
      url: '/ajax/select2Barang?pelayanan={{ $nomorAntrian->perusahaanAsuransi->nama_perusahaan}}&poliklinik_id='+{{ Auth::user()->poliklinik_id }},
      dataType: 'json',
      delay: 250,
      processResults: function(data) {
        return {
          results: $.map(data, function(item) {
            return {
              text: item.nama_barang,
              harga: item.harga,
              id: item.id
            }
          })
        };
      },
      cache: true
    }
  });

    $('#diagnosa_id').select2({
    placeholder: 'Cari Riwayat Penyakit',
    multiple: false,
    ajax: {
      url: '/ajax/select2ICD',
      dataType: 'json',
      delay: 250,
      multiple: false,
      processResults: function(data) {
        return {
          results: $.map(data, function(item) {
            return {
              text: item.kode+' - '+item.indonesia,
              id: item.id
            }
          })
        };
      },
      cache: true
    }
  });
  });




   // KELOLA TINDAKAN =======================
  function load_daftar_tindakan(){
    $.ajax({
    url: "/pendaftaran-tindakan/<?php echo $nomorAntrian->id;?>",
    method: 'GET',
    success: function (response) {
        $("#daftar_tindakan").html(response);
      }
    });
  }

  function hapus_daftar_tindakan(id){
    $.ajax({
    url: "/pendaftaran-tindakan/"+id,
    data: {"_token": "{{ csrf_token() }}"},
    method: 'DELETE',
    success: function (response) {
        console.log(response);
        load_daftar_tindakan();
      }
    });
  }

  function simpan_daftar_tindakan(){
    let tindakan_id = $('#tindakan_id').select2('data')[0].id
    let dokter = $('#dokter').find(":selected").val();
    let asisten = $('#asisten').find(":selected").val();
    
    $.ajax({
      url: "/pendaftaran-tindakan",
      method: 'POST',
      data: {
        tindakan_id: tindakan_id,
        poliklinik_id: {{ $nomorAntrian->poliklinik_id}},
        dokter: dokter,
        "_token": "{{ csrf_token() }}",
        asisten: asisten,
        pendaftaran_id: '{{$nomorAntrian->pendaftaran->id}}'
      },
      success: (response) => {
        $('#exampleModal').modal('hide');
        load_daftar_tindakan();
      }
    })
  }

  // END KELOLA TINDAKAN =======================


  function check_anamnesa(){
    var anamnesa = $(".anamnesa").val();
    console.log(anamnesa);
    if(anamnesa == "")
    {
      $(".btn-selesai").attr('href', '#');
      $('.btn-selesai').attr('disabled', true);
      $('.btn-surat').prop('disabled', true);
    }else{
      $(".btn-selesai").attr('href', '/pendaftaran/{{$nomorAntrian->id}}/selesai');
      $('.btn-selesai').attr('disabled', false);
      $('.btn-surat').prop('disabled', false);
    }
  }


// CATATAN HARIAN
  function simpan_catatan_harian(){
    var tanggal = $(".tanggal_txt").val();
    var catatan = $(".catatan").val();
    
    $.ajax({
      url: "/pendaftaran-catatan-harian",
      method: 'POST',
      data: {
        tanggal:tanggal,
        _token: '{{csrf_token()}}',
        catatan:catatan,
        pendaftaran_id: '{{$nomorAntrian->pendaftaran->id}}'
      },
      success: (response) => {
        $('#modal-catatan-harian').modal('hide');
        load_catatan_harian();
      }
    })
  }

  function load_catatan_harian(){
    $.ajax({
    url: "/pendaftaran-catatan-harian/<?php echo $nomorAntrian->id;?>",
    method: 'GET',
    success: function (response) {
        $("#catatan_harian").html(response);
      }
    });
  }

  function filter_rujukan_tindakan(){
    $.ajax({
      url: "/ajax/filter_tindakan_rujukan",
      method: 'GET',
      data:{ poliklinik_id:$(".poliklinik_id").val()},
      success: (response) => {
        console.log(response);
      }
    })
  }

  function hapus_catatan_harian(id){
    $.ajax({
    url: "/pendaftaran-catatan-harian/"+id,
    data: {"_token": "{{ csrf_token() }}"},
    method: 'DELETE',
    success: function (response) {
      load_catatan_harian();
      }
    });
  }





  // CEK RUJUKAN, KALAU BELUM ADA DISABLE BUTTON SIMPAN

  function checkTindakanKetikaRujukan(){
    $.ajax({
    url: "/ajax/check-tindakan-rujukan",
    data:{
      pasien_id:{{ $nomorAntrian->pendaftaran->pasien_id}},
      perusahaan_asuransi_id:{{ $nomorAntrian->perusahaan_asuransi_id}}
    },
    method: 'GET',
    success: function (response) {
      console.log(response);
      if(response<1){
        $(".btn-simpan-rujukan").attr("disabled", true);
      }else{
        $(".btn-simpan-rujukan").attr("disabled", false);
      }
      }
    });
    
  }






  // KELOLA DATA DIAGNOSA ==========================================
  function load_daftar_diagnosa(){
    $.ajax({
    url: "/pendaftaran-diagnosa/<?php echo $nomorAntrian->id;?>",
    method: 'GET',
    success: function (response) {
        $("#daftar_diagnosa").html(response);
      }
    });
  }



  function check_lock_bpjs(){
    if($("#lock_bpjs").is(':checked'))
    {
      var lock_bpjs = "yes";
    }else{
      var lock_bpjs = "no";
    }
    console.log(lock_bpjs);
      $.ajax({
        url: "/ajax/lock_bpjs",
        type: "get", //send it through get method
        data: { 
          lock_bpjs: lock_bpjs
        },
        success: function(response) {
          console.log(response);
        },
        error: function(xhr) {
          //Do Something to handle error
        }
  });
  }
  function simpan_daftar_diagnosa()
  {
    let diagnosa = $('#diagnosa_id').select2('data')[0].id;

    $.ajax({
      url: '/pendaftaran-diagnosa',
      method: 'POST',
      data: {
        _token: '{{csrf_token()}}',
        pendaftaran_id: '{{$nomorAntrian->pendaftaran->id}}',
        poliklinik_id: {{ $nomorAntrian->poliklinik_id}},
        tbm_icd_id: diagnosa,
      },
      success: (response) => {
        $('#modal-diagnosa').modal('hide')
        load_daftar_diagnosa();
      }
    })
  }

  function hapus_daftar_diagnosa(id){
    $.ajax({
    url: "/pendaftaran-diagnosa/"+id,
    data: {"_token": "{{ csrf_token() }}"},
    method: 'DELETE',
    success: function (response) {
        load_daftar_diagnosa();
      }
    });
  }

  // END KELOLA DATA DIAGNOSA ===========================

  // KELOLA OBAT RACIK
  function load_daftar_obat_racik(){
    $.ajax({
    url: "/pendaftaran-resep-racik/<?php echo $nomorAntrian->id;?>",
    method: 'GET',
    success: function (response) {
        $("#daftar_obat_non_racik").html(response);
      }
    });
  }

  function hapus_daftar_obat_racik(id){
    $.ajax({
      url: "/pendaftaran-resep-racik/"+id,
    data: {"_token": "{{ csrf_token() }}"},
    method: 'DELETE',
    success: function (response) {
        load_daftar_obat_racik();
      }
    });
  }

  function add_komposisi(id){
    $.ajax({
      url: "/pendaftaran-resep-racik/add_komposisi",
      method: 'GET',
      data:{id:id},
      success: function (response) {
        console.log(response);
          $(response).insertAfter( ".inner-"+id );
          create_select_barang(id);
        }
      });
  }

  function create_select_barang(id){
    $('.barang_id_txt_'+id).select2({
          placeholder: 'Cari Barang',
          tags: true,
          ajax: {
            url: '/ajax/select2Barang?pelayanan={{ $nomorAntrian->perusahaanAsuransi->nama_perusahaan}}&poliklinik_id='+{{ Auth::user()->poliklinik_id }},
            dataType: 'json',
            delay: 250,
            processResults: function(data) {
              return {
                results: $.map(data, function(item) {
                  return {
                    text: item.nama_barang,
                    harga: item.harga,
                    id: item.id
                  }
                })
              };
            },
            cache: true
          }
        });
  }

  function hapus_komposisi(id){
    console.log(id);
    $(".komposisi-"+id).remove();
  }

  function add_obat_racik(){
    var id = 2;
    $.ajax({
      url: "/pendaftaran-resep-racik/add_obat_racik",
      data:{id:id},
      method: 'GET',
      success: function (response) {
        console.log(response);
          $(response).insertAfter( ".inner2" );
          create_select_barang(2);
        }
      });
  }

  function hapus_obat_racik_form(item){
    console.log(item);
    $(".form-racik-"+item).hide();
  }

  //END KELOLA OBAT RACIK

   // KELOLA DATA Obat Non Racik ===========================

   function load_daftar_obat_non_racik(){
    $.ajax({
    url: "/pendaftaran-resep/<?php echo $nomorAntrian->id;?>",
    method: 'GET',
    success: function (response) {
        $("#daftar_obat_racik").html(response);
      }
    });
  }


  function simpan_daftar_obat_non_racik(){
    let barang_id = $('#barang_id').select2('data')[0].id
    let jumlah = $('#jumlah').val()
    let satuan = $('#satuan').val()
    let aturan_pakai = $('#aturan_pakai').val()
    $.ajax({
      url: '/pendaftaran-resep',
      method: 'POST',
      data: {
        _token: '{{csrf_token()}}',
        barang_id: barang_id,
        jumlah: jumlah,
        satuan: satuan,
        pendaftaran_id: '{{$nomorAntrian->pendaftaran->id}}',
        poliklinik_id: {{ $nomorAntrian->poliklinik_id}},
        aturan_pakai: aturan_pakai,
        jenis: 'racik'
      },
      success: (response) => {
        $('#modal-obat-non-racik').modal('hide')
        load_daftar_obat_non_racik();
      }
    })
  }

  function hapus_daftar_obat_non_racik(id){
    $.ajax({
    url: "/pendaftaran-resep/"+id,
    data: {"_token": "{{ csrf_token() }}"},
    method: 'DELETE',
    success: function (response) {
      load_daftar_obat_non_racik();
      }
    });
  }

  // RUJUKAN LABORATORIUM

  function load_rujukan_internal(){
    console.log("Loading rujukan internal");
    $.ajax({
    url: "/pendaftaran-rujukan/<?php echo $nomorAntrian->id;?>",
    method: 'GET',
    success: function (response) {
        $("#rujukan_internal").html(response);
      }
    });
  }

  function hapus_rujukan(id){
    $.ajax({
    url: "/pendaftaran-rujukan/"+id,
    data: {"_token": "{{ csrf_token() }}"},
    method: 'DELETE',
    success: function (response) {
        load_rujukan_internal();
      }
    });
  }


  function tambah_bhp(pendaftaran_tindakan_id){
    console.log(pendaftaran_tindakan_id);
    $(".txt_pendaftaran_tindakan_id").val(pendaftaran_tindakan_id);
  }

  function simpan_daftar_rujukan()
  {
    var jenis_pemeriksaan_laboratorium_id = $(".jenis_pemeriksaan_laboratorium_id").val();
    var user_id                           = $(".user_id").val();
    var poliklinik_id                     = $(".poliklinik_id").val();
    var catatan                           = $(".catatan_rujukan_internal").val();
    
    $.ajax({
      url: "/pendaftaran-rujukan",
      data: {
        "_token": "{{ csrf_token() }}",
        user_id:user_id,
        pendaftaran_id: '{{$nomorAntrian->pendaftaran->id}}',
        poliklinik_id:poliklinik_id,
        catatan:catatan,
        jenis_pemeriksaan_laboratorium_id:jenis_pemeriksaan_laboratorium_id
      },
      method: 'POST',
      success: function (response) {
          
          $('#modal-rujukan-laporatorium').modal('hide')
          load_rujukan_internal();
        }
      });
  }
  // END RUJUKAN LABORATORIUM



  function simpan_anamnesa(){
    console.log("simpan anamnesa");
    var poliklinik_id                     = $(".poliklinik_id").val();
    var anamnesa                          = $(".anamnesa").val();
    $.ajax({
      url: '/ajax/simpan-anamnesa',
      data: {
        "_token": "{{ csrf_token() }}",
        nomor_antrian_id: '{{$nomorAntrian->id}}',
        anamnesa:anamnesa
      },
      type: "GET",
      success: function(res) {
        $("#hasil_riwayat").html(res);
        console.log(res);
        check_anamnesa();
      },
      error: function(err) {
        console.log(err);
      }
    })
  }

  function hapus_bhp_tindakan(tindakan_id,barang_id,pendaftaran_id){
        console.log(tindakan_id);
        console.log(barang_id);
        console.log(pendaftaran_id);
        $.ajax({
        url: "/ajax/pendaftaran-bhp-delete",
        type: 'GET',
        data:{tindakan_id:tindakan_id,barang_id,pendaftaran_id},
        success: function(res) {
            console.log(res);
            load_daftar_tindakan();
        }
    });
  }

  function simpan_bhp_tambahan(){
    var jumlah                    = $("#bhp_qty_txt").val();
    var pendaftaran_tindakan_id   = $(".txt_pendaftaran_tindakan_id").val();
    var barang_id                 = $('#barang_id_txt_bhp').select2('data')[0].id;
    console.log(jumlah);
    console.log(pendaftaran_tindakan_id);
    console.log(barang_id);
    $.ajax({
        url: "/ajax/pendaftaran-bhp-insert",
        type: 'GET',
        data:{jumlah:jumlah,pendaftaran_tindakan_id:pendaftaran_tindakan_id,barang_id:barang_id},
        success: function(res) {
          $('#myModalCustomBHP').modal('hide');
            load_daftar_tindakan();
        }
    });
  }

  function showTindakanLab(){
        var tindakan_id                 = $(".jenis_pemeriksaan_laboratorium_id").val();
        $.ajax({
                url: "/pendaftaran-tindakan-temp",
                type: "GET",
                data: {
                    pasien_id: {{ $nomorAntrian->pendaftaran->pasien->id}},
                    perusahaan_asuransi_id : {{ $nomorAntrian->perusahaan_asuransi_id}}
                },
                success: function (response) {
                    $("#tindakan-temp").html(response);
                }
        });
    }

    function deleteTindakanTemp(id){
        $.ajax({
                url: "/pendaftaran-tindakan-temp/"+id,
                type: "DELETE",
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function (response) {
                    showTindakanLab();
                    checkTindakanKetikaRujukan();
                }
        });
    }

  function tambahTindakanLab(){
        var tindakan_id                 = $(".jenis_pemeriksaan_laboratorium_id").val();
        console.log(tindakan_id);
        $.ajax({
                url: "/pendaftaran-tindakan-temp",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    pasien_id: {{ $nomorAntrian->pendaftaran->pasien->id}},
                    tindakan_id: tindakan_id,
                    perusahaan_asuransi_id : {{ $nomorAntrian->perusahaan_asuransi_id}}
                },
                success: function (response) {
                    console.log(response);
                    showTindakanLab();
                    checkTindakanKetikaRujukan();
                }
        });
    }





  // Handle detail riwayat kunjungan
  $('.kode').on('click', function() {
    let idPendaftaran = $(this).attr('data-kode');
    // console.log(idPendaftaran);
    $("#resume-medis").attr("href", "/pendaftaran/"+idPendaftaran+"/cetak_rekamedis");
    let url = "/log-riwayat-kunjungan/" + idPendaftaran
    $.ajax({
      url: url,
      type: "GET",
      success: function(res) {
        $("#hasil_riwayat").html(res);
        console.log(res);
      },
      error: function(err) {
        console.log(err);
      }
    })
  })
</script>
@endpush

@push('css')
  <link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
  <link href="{{asset('/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
  
@endpush
