@extends('layouts.topnavlayout')
@section('title',"Pendaftaran $pendaftaran->kode")
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Pendaftaran
      <small>{{ $pendaftaran->kode }}</small>
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
                <td>{{ $pendaftaran->pasien->nomor_rekam_medis }}</td>
              </tr>
              <tr>
                <td>Nama</td>
                <td>{{ $pendaftaran->pasien->nama }}</td>
              </tr>
              <tr>
                <td>Tempat, Tgl Lhr</td>
                <td>{{ $pendaftaran->pasien->tempat_lahir }}, {{ tgl_indo($pendaftaran->pasien->tanggal_lahir) }}</td>
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

            <h4>Riwayat Kunjungan Sebelumnya</h4>
            <table class="table table-bordered">
              <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Penjamin</th>
                <th>Dokter</th>
                <th>Poliklinik</th>
                <th width="30"></th>
              </tr>
              @foreach($riwayatKunjungan as $riwayat)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ tgl_indo(substr($riwayat->created_at, 0,10)) }}</td>
                <td>{{ $riwayat->perusahaanAsuransi->nama_perusahaan }}</td>
                <td>{{ $riwayat->dokter->name }}</td>
                <td>{{ $riwayat->poliklinik->nama }}</td>
                <td>
                  <button type="button" data-kode="{{ $riwayat->id }}" class="btn btn-primary btn-sm kode" data-toggle="modal" data-target="#modalHistoryPendaftaran">
                    <i class='fa fa-eye' aria-hidden='true'></i>
                  </button>

                </td>
              </tr>
              @endforeach
            </table>
            <hr>

            <a href="/pendaftaran/{{ $pendaftaran->id }}/selesai" class="btn btn-danger btn-lg">Tandai Selesai Pelayanan</a>
          </div>
        </div>
      </div>
      <div class="col-xs-6">
        <div class="box">
          <div class="box-body">
            <h4>Daftar Tindakan
              <button style="float: right" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-tindakan">
                Input Tindakan
              </button>
            </h4>
            <hr>
            <div id="table-tindakan">
              <table class="table table-bordered" id="tindakan-table">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Kode ICD 9</th>
                    <th>Nama Tindakan</th>
                    <th>Fee</th>
                    <th width="10">#</th>
                  </tr>
                </thead>
              </table>
            </div>
            <hr style="border:1px dashed">
            <h4>Daftar Diagnosa <button style="float: right" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-diagnosa">
                Input Diganosa
              </button></h4>
            <hr>
            <div id="table-diagnosa">
              <table class="table table-bordered" id="diagnosa-table">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Kode ICDController</th>
                    <th>Nama Diganosa</th>
                    <th width="10">#</th>
                  </tr>
                </thead>
              </table>
            </div>
            <hr style="border:1px dashed">
            <h4>Daftar Obat Racik <button style="float: right" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-obat-racik">
                Input Obat Racik
              </button></h4>
            <hr>
            <div id="table-obat-racik">
              <table class="table table-bordered" id="obat-racik-table">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Obat</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Keterangan</th>
                    <th width="10">#</th>
                  </tr>
                </thead>
              </table>
            </div>

            <hr style="border:1px dashed">
            <h4>Rujukan Laboratorium <button style="float: right" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-rujukan">
                Input Rujukan
              </button></h4>
            <hr>
            <table class="table table-bordered" id="rujukan-table">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Dokter Perujuk</th>
                  <th>Nama Laboratorium</th>
                  <th>Jenis Pemeriksaan</th>
                  <th>Status</th>
                  <th width="10">#</th>
                </tr>
              </thead>
            </table>
            <hr style="border:1px dashed">
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- Modal Rujukan -->
<div class="modal fade" id="modal-tindakan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Form Input Tindakan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <table class="table table-bordered table-bordered">
              <tr>
                <th colspan="2">FORM INPUT TINDAKAN</th>
              </tr>
              <tr>
                <td>Pilih Tindakan</td>
                <td>
                  <select style="width: 100%" name="tindakan_id" id="tindakan_id" class='select2 form-control'>
                  </select>
                </td>
              </tr>
              <tr>
                <td>Dokter</td>
                <td>
                  {!! Form::select('dokter', $dokter, null, ['class'=>'form-control', 'id' => 'dokter']) !!}
                </td>
              </tr>
              <tr>
                <td>Asistensi</td>
                <td>
                  {!! Form::select('asisten', $dokter, null, ['class'=>'form-control', 'id' => 'asisten']) !!}
                </td>
              </tr>
              <tr>
                <td></td>
                <td>
                  <div class="btn btn-primary add-item" onClick="addItem(this)" data-jenis='tindakan'>
                    <i class="fa fa-plus"></i>
                    Tambah
                  </div>
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Rujukan -->
<div class="modal fade" id="modal-rujukan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Form Input Rujukan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <table class="table table-bordered table-bordered">
              <tr>
                <th colspan="2">FORM INPUT RUJUKAN LABORATORIUM</th>
              </tr>
              <tr>
                <td>Pilih Poliklinik</td>
                <td>
                  <select name="poliklinik_id" id="poliklinik_id" class='select2 form-control' style="width:100%">
                  </select>
                </td>
              </tr>
              <tr>
                <td>Pilih Dokter Perujuk</td>
                <td>
                  <select name="users_id" id="users_id" class='select2 form-control' style="width:100%">
                  </select>
                </td>
              </tr>
              <tr>
                <td>Pilih Tindakan Laboratorium</td>
                <td>
                  <select name="tindakan_id" id="tindakan_lab_id" class='select2 form-control' style="width:100%">
                  </select>
                </td>
              </tr>
              <tr>
                <td></td>
                <td>
                  <div class="btn btn-primary add-item pull-right" onclick="addRujukan(this)" data-jenis='rujukan'>
                    <i class="fa fa-new"></i>
                    Buat Rujukan
                  </div>
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Diagnosa -->
<div class="modal fade" id="modal-diagnosa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <th colspan="2">FORM INPUT DIAGNOSA</th>
              </tr>
              <tr>
                <td>Pilih Diagnosa</td>
                <td>
                  <select name="diagnosa_id" id="diagnosa_id" class='select2 form-control' style="width: 100%">
                  </select>
                </td>
              </tr>
              <tr>
                <td></td>
                <td>
                  <div class="btn btn-primary add-item" onclick="addDiagnosa(this)" data-jenis='diagnosa'>
                    <i class="fa fa-plus"></i>
                    Tambah
                  </div>
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Obat Racik -->
<div class="modal fade" id="modal-obat-racik" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
            <table class="table table-bordered table-bordered">
              <tr>
                <th colspan="2">FORM INPUT OBAT RACIK</th>
              </tr>
              <tr>
                <td>Pilih Barang</td>
                <td>
                  <select name="barang_id" id="barang_id" class='form-control' style="width:100%">
                  </select>
                </td>
              </tr>
              <tr>
                <td>Harga</td>
                <td>
                  <input type="number" name="harga" id="harga" class="form-control" placeholder="Masukan harga obat">
                </td>
              </tr>
              <tr>
                <td>Jumlah</td>
                <td>
                  <input type="number" name="jumlah" id="jumlah" class="form-control" placeholder="Masukan jumlah obat">
                </td>
              </tr>
              <tr>
                <td>Satuan</td>
                <td>
                  <input type="text" name="satuan" id="satuan" class="form-control" placeholder="Masukan satuan obat">
                </td>
              </tr>
              <tr>
                <td>Aturan Pakai</td>
                <td>
                  <textarea name="aturan_pakai" id="aturan_pakai" class="form-control" placeholder="Aturan pakai obat" cols="30" rows="10"></textarea>
                  </select>
                </td>
              </tr>
              <tr>
                <td></td>
                <td>
                  <div class="btn btn-primary add-item" onClick="addObatRacik(this)" data-jenis='tindakan'>
                    <i class="fa fa-plus"></i>
                    Tambah
                  </div>
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal history pendafatran -->
<div class="modal fade" id="modalHistoryPendaftaran" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Riwayat Pelayanan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <tr>
            <td>Nama Pasien</td>
            <td>:</td>
            <th id="pasien"></th>
          </tr>
          <tr>
            <td>Diagnosa</td>
            <td>:</td>
            <th id="diagnosa"></th>
          </tr>
          <tr>
            <td>Tindakan</td>
            <td>:</td>
            <th id="tindakan"></th>
          </tr>
          <tr>
            <td>Obat</td>
            <td>:</td>
            <th id="obat"></th>
          </tr>
        </table>

        <h4>Riwayat Tindakan</h4>
        <table class="table table-bordered">
          <tr>
            <th>Nomor</th>
            <th>Kode ICD 9</th>
            <th>Nama Tindakan</th>
          </tr>
          <tr>
            <td>1</td>
            <td>sample</td>
            <td>sample</td>
          </tr>
        </table>

        <h4>Riwayat Diagnosa</h4>
        <table class="table table-bordered">
          <tr>
            <th>Nomor</th>
            <th>Kode ICD</th>
            <th>Nama Diagnosa</th>
          </tr>
          <tr>
            <td>1</td>
            <td>sample</td>
            <td>sample</td>
          </tr>
        </table>
        <h4>Riwayat Pemberian Obat</h4>
        <table class="table table-bordered">
          <tr>
            <th>Nomor</th>
            <th>Nama Obat</th>
            <th>Jumlah Dan Keterangan</th>
          </tr>
          <tr>
            <td>1</td>
            <td>sample</td>
            <td>sample</td>
          </tr>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('css')
<link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
<link href="{{asset('/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
@endpush

@push('scripts')
<script src="{{asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('adminlte/bower_components/select2/dist/js/select2.min.js')}}"></script>
<script src="{{asset('datatables/datatables.min.js') }}"></script>
<script>
  function addItem(btn) {
    let tindakan_id = $('#tindakan_id').select2('data')[0].id
    let dokter = $('#dokter').find(":selected").val();
    let asisten = $('#asisten').find(":selected").val();
    $.ajax({
      url: '/tindakan-add-item',
      method: 'GET',
      data: {
        tindakan_id: tindakan_id,
        dokter: dokter,
        asisten: asisten,
        pendaftaran_id: '{{$pendaftaran->id}}'
      },
      success: (response) => {
        $('#table-tindakan').html(response)
        getResumeTindakan()
      }
    })
  }

  function removeItem(btn) {
    let id = btn.getAttribute('data-id')
    $.ajax({
      url: '/resume/tindakan/' + id,
      method: 'DELETE',
      data: {
        _token: '{{csrf_token()}}'
      },
      success: (response) => {
        $('#table-tindakan').html(response)
        getResumeTindakan()
      }
    })
  }

  function getResumeTindakan() {
    $('#tindakan-table').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: '{{ route("resume.tindakan") }}',
        data: {
          pendaftaran_id: '{{$pendaftaran->id}}'
        }
      },
      columns: [{
          data: 'DT_RowIndex',
          orderable: false,
          searchable: false
        },
        {
          data: 'kode',
          name: 'kode'
        },
        {
          data: 'tindakan.tindakan',
          name: 'tindakan.tindakan'
        },
        {
          data: 'fee',
          name: 'fee'
        },
        {
          data: 'action',
          name: 'action'
        }
      ]
    });
  }

  $(function() {
    getResumeTindakan()

    $('#tindakan_id').select2({
      placeholder: 'Cari tindakan',
      multiple: false,
      ajax: {
        url: '/ajax/select2Tindakan',
        dataType: 'json',
        delay: 250,
        multiple: false,
        processResults: function(data) {
          return {
            results: $.map(data, function(item) {
              return {
                text: item.kode + ' - ' + item.tindakan,
                id: item.id
              }
            })
          };
        },
        cache: true
      }
    });
  });


  getRujukan()
  $('#users_id').select2({
    placeholder: 'Cari Dokter',
    multiple: false,
    ajax: {
      url: '/ajax/select2Dokter',
      dataType: 'json',
      delay: 250,
      multiple: false,
      processResults: function(data) {
        return {
          results: $.map(data, function(item) {
            return {
              text: item.name,
              id: item.id
            }
          })
        };
      },
      cache: true
    }
  });

  $('#tindakan_lab_id').select2({
    placeholder: 'Cari Tindakan Lab',
    multiple: false,
    ajax: {
      url: '/ajax/select2TindakanLaboratorium',
      dataType: 'json',
      delay: 250,
      multiple: false,
      processResults: function(data) {
        return {
          results: $.map(data, function(item) {
            return {
              text: item.nama_jenis,
              id: item.id
            }
          })
        };
      },
      cache: true
    }
  });

  $('#poliklinik_id').select2({
    placeholder: 'Cari Poliklinik',
    multiple: false,
    ajax: {
      url: '/ajax/select2Poliklinik',
      dataType: 'json',
      delay: 250,
      multiple: false,
      processResults: function(data) {
        return {
          results: $.map(data, function(item) {
            return {
              text: item.nama,
              id: item.id
            }
          })
        };
      },
      cache: true
    }
  });

  function getRujukan() {
    $('#rujukan-table').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: '{{ route("resume.rujukanLab") }}',
        data: {
          id: '{{$pendaftaran->pasien_id}}'
        }
      },
      columns: [{
          data: 'DT_RowIndex',
          orderable: false,
          searchable: false
        },
        {
          data: 'dokter',
          name: 'dokter'
        },
        {
          data: 'dokter',
          name: 'dokter'
        },
        {
          data: 'tindakan',
          name: 'tindakan'
        },
        {
          data: 'dokter',
          name: 'dokter'
        },
        {
          data: 'action',
          name: 'action'
        }
      ]
    });
  }

  function addRujukan(btn) {
    let poliklinik = $('#poliklinik_id').select2('data')[0].id;
    let tindakan = $('#tindakan_id').select2('data')[0].id;
    let dokter = $('#users_id').select2('data')[0].id;
    let pasien_id = '{{$pendaftaran->pasien_id}}';
    let pendaftaran_id = '{{$pendaftaran->id}}';

    $.ajax({
      url: '/rujukan-lab-add-item',
      method: 'POST',
      data: {
        _token: '{{csrf_token()}}',
        poliklinik_id: poliklinik,
        tindakan_id: tindakan,
        users_id: dokter,
        pasien_id: pasien_id,
        pendaftaran_id: pendaftaran_id
      },
      success: (response) => {
        $('#modal-rujukan').modal('hide')
        window.location.replace('/pendaftaran')
      }
    })
  }

  function removeRujukan(btn) {
    let id = btn.getAttribute('data-id')
    $.ajax({
      url: '/rujukan-lab-remove-item/' + id,
      method: 'DELETE',
      data: {
        _token: '{{csrf_token()}}'
      },
      success: (response) => {
        $('#table-rujukan').html(response)
        getRujukan()
      }
    })
  }


  getObatRacik()
  $('#barang_id').select2({
    placeholder: 'Cari Barang',
    ajax: {
      url: '/ajax/select2Barang',
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

  $('#barang_id').on('change', () => {
    let source = $("#barang_id :selected").data().data.harga;
    $("#harga").val(source)
  })

  function getObatRacik() {
    $('#obat-racik-table').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: '/resume/obatRacik',
        data: {
          id: '{{$pendaftaran->id}}',
          jenis: 'racik'
        }
      },
      columns: [{
          data: 'DT_RowIndex',
          orderable: false,
          searchable: false
        },
        {
          data: 'kode',
          name: 'kode'
        },
        {
          data: 'nama',
          name: 'nama'
        },
        {
          data: 'harga',
          name: 'harga'
        },
        {
          data: 'jumlah',
          name: 'jumlah'
        },
        {
          data: 'aturan_pakai',
          name: 'aturan_pakai'
        },
        {
          data: 'action',
          name: 'action'
        }
      ]
    });
  }

  function addObatRacik(btn) {
    let barang_id = $('#barang_id').select2('data')[0].id
    let jumlah = $('#jumlah').val()
    let satuan = $('#satuan').val()
    let harga = $('#harga').val()
    let aturan_pakai = $('#aturan_pakai').val()
    $.ajax({
      url: '/obat-racik-add-item/{{$pendaftaran->id}}',
      method: 'POST',
      data: {
        _token: '{{csrf_token()}}',
        barang_id: barang_id,
        jumlah: jumlah,
        satuan: satuan,
        harga: harga,
        aturan_pakai: aturan_pakai,
        jenis: 'racik'
      },
      success: (response) => {
        $('#barang_id').val(null)
        $('#harga').val(null)
        $('#satuan').val(null)
        $('#jumlah').val(null)
        $('#aturan_pakai').val(null)
        $('#modal-obat-racik').modal('hide')
        $('#table-obat-racik').html(response)
        getObatRacik()
      }
    })
  }

  function removeObatRacik(btn) {
    let id = btn.getAttribute('data-id')
    $.ajax({
      url: '/obat-racik-remove-item/' + id,
      method: 'DELETE',
      data: {
        _token: '{{csrf_token()}}'
      },
      success: (response) => {
        $('#table-obat-racik').html(response)
        getObatRacik()
      }
    })
  }


  getDiagnosa()
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
              text: item.indonesia,
              id: item.id
            }
          })
        };
      },
      cache: true
    }
  });

  function getDiagnosa() {
    $('#diagnosa-table').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: '{{ route("resume.diagnosaICD") }}',
        data: {
          id: '{{$pendaftaran->id}}'
        }
      },
      columns: [{
          data: 'DT_RowIndex',
          orderable: false,
          searchable: false
        },
        {
          data: 'kode',
          name: 'kode'
        },
        {
          data: 'tbm_icd',
          name: 'tbm_icd'
        },
        {
          data: 'action',
          name: 'action'
        }
      ]
    });
  }

  function addDiagnosa(btn) {
    let diagnosa = $('#diagnosa_id').select2('data')[0].id;

    $.ajax({
      url: '/diagnosa-add-item/{{$pendaftaran->id}}',
      method: 'POST',
      data: {
        _token: '{{csrf_token()}}',
        tbm_icd_id: diagnosa,
      },
      success: (response) => {
        $('#modal-diagnosa').modal('hide')
        $('#table-diagnosa').html(response)
        getDiagnosa()
      }
    })
  }

  function removeDiagnosa(btn) {
    let id = btn.getAttribute('data-id')
    $.ajax({
      url: '/diagnosa-remove-item/' + id,
      method: 'DELETE',
      data: {
        _token: '{{csrf_token()}}'
      },
      success: (response) => {
        $('#table-diagnosa').html(response)
        getDiagnosa()
      }
    })
  }


  $('.kode').on('click', function() {
    let idPendaftaran = $(this).attr('data-kode')
    let url = "/pasien/riwayatKunjungan/" + idPendaftaran
    $.ajax({
      url: url,
      type: "GET",
      success: function(res) {
        let obat = []
        let tindakan = []
        let diagnosa = []

        res.obat.forEach(function(el) {
          obat.push(el.barang.nama_barang)
        })

        res.diagnosa.forEach(function(el) {
          diagnosa.push(el.icd.indonesia)
        })

        res.tindakan.forEach(function(el) {
          tindakan.push(el.tindakan.tindakan)
        })

        $('#pasien').html(res.pasien)
        $('#diagnosa').html(diagnosa.join(", "))
        $('#tindakan').html(tindakan.join(", "))
        $('#obat').html(obat.join(", "))

      },
      error: function(err) {
        console.log(err);
      }
    })
  })
</script>
@endpush