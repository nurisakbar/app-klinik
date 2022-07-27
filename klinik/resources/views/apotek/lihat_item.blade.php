@extends('layouts.app')
@section('title',"Lihat Item")
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
          <div class="col-xs-5">
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
              </div>
            </div>
          </div>
          <div class="col-xs-7">
            <div class="box">
              <div class="box-body">

                  <h4>Daftar Obat Non Racik</h4>
                  <hr>
                  <table class="table table-bordered">
                    <tr>
                        <th width="10">No</th>
                        <th>Nama Obat</th>
                        <th>Jumlah</th>
                        <th>Keterangan</th>
                        <th width="100">Harga</th>
                        <th width="100">Subtotal</th>
                        <th>#</th>
                    </tr>
                    @if($pendaftaranResep->count() < 1)
                    <tr>
                        <td colspan="4">Belum Ada Data</td>
                    </tr>
                    @else
                        @foreach($pendaftaranResep->get() as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->barang->nama_barang}}</td>
                            <td>{{ $row->jumlah .' '.$row->barang->satuanTerkecil->satuan}}</td>
                            <td>{{ $row->aturan_pakai }}</td>
                            <td>{{ convert_rupiah($row->harga) }}</td>
                            <td>{{ convert_rupiah($row->jumlah * $row->harga) }}</td>
                            <td>
                              <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" onClick="showPendaftaranResep({{$row->id}})" data-target="#exampleModal">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                              </button>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </table>
                <br><br>

                  <div id="daftar_obat_racik"></div>
                  <h4>Daftar Obat Racik</h4>
                  <hr>

                  <table class="table table-bordered">
                    <tr>
                        <th width="10">No</th>
                        <th>Jumlah Kemasan</th>
                        <th>Aturan Pakai</th>
                        <th>Detail</th>
                        <th>
                          #
                        </th>
                    </tr>
                    @if($pendaftaranResepRacik->count() < 1)
                    <tr>
                        <td colspan="4">Belum Ada Data</td>
                    </tr>
                    @else
                        @foreach($pendaftaranResepRacik->get() as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->jumlah_kemasan}} - {{ $row->satuan->satuan }}</td>
                            <td>{{ $row->aturan_pakai}}</td>
                            <td>
                                @foreach($row->detail as $item)
                                - {{ $item->barang->nama_barang}} x {{ $item->jumlah}}
                                @if(count($row->detail)>1)
                                <br>
                                @endif
                                @endforeach
                            </td>
                            <td>
                              <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" onClick="showPendaftaranObatRacik({{$row->id}})" data-target="#exampleModal2">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                              </button>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </table>

                <hr>
                <a href="/pendaftaran" class="btn btn-danger">Kembali</a>
                <a target="new" href="/pendaftaran/{{ $nomorAntrian->pendaftaran->id }}/cetak_label" class="btn btn-danger">Cetak E - Tiket</a>
              </div>
            </div>
          </div>
        </div>
      </section>
  </div>

<!-- Modal Obat Non Racik-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detail Obat Non Racik</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="pendaftaran_resep_id">
        <table class="table table-bordered">
          <tr>
            <td>Nama Barang</td>
            <td>
              <span id="nama_barang"></span>
            </td>
          </tr>
          <tr>
            <td>Qty</td>
            <td>
              <input type="text" class="form-control jumlah" placeholder="Qty">
            </td>
          </tr>
          <tr>
            <td>Aturan Pakai</td>
            <td>
              <input type="text" class="form-control aturan_pakai" placeholder="Aturan Pakai">
            </td>
          </tr>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary" onClick="simpanPendaftaranResep()">Simpan</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal Obat Racik-->
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detail Obat Racik</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="pendaftaran_obat_racik_id">
        <table class="table table-bordered">
          {{-- <tr>
            <td>Nama Barang</td>
            <td>
              <span id="nama_barang"></span>
            </td>
          </tr> --}}
          <tr>
            <td>Jumlah</td>
            <td>
              <input type="text" class="form-control racik_jumlah" placeholder="Qty">
            </td>
          </tr>
          <tr>
            <td>Aturan Pakai</td>
            <td>
              <input type="text" class="form-control racik_aturan_pakai" placeholder="Aturan Pakai">
            </td>
          </tr>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary" onClick="simpanPendaftaranRacik()">Simpan</button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
function showPendaftaranResep(id){
  console.log(id);
  $.ajax({
        url: "/pendaftaran-resep",
        data:{id:id},
        type: 'GET',
        success: function(res) {
            $(".aturan_pakai").val(res.aturan_pakai);
            $(".jumlah").val(res.jumlah);
            $("#nama_barang").html(res.barang.nama_barang);
            $("#pendaftaran_resep_id").val(res.id);
        }
    });
}

function simpanPendaftaranResep(){
  var aturan_pakai  = $(".aturan_pakai").val();
  var jumlah        = $(".jumlah").val();
  var id            = $("#pendaftaran_resep_id").val();
  $.ajax({
        url: "/pendaftaran-resep/"+id,
        data:{id:id,aturan_pakai:aturan_pakai,jumlah:jumlah,"_token": "{{ csrf_token() }}"},
        type: 'PUT',
        success: function(res) {
            location.reload(); 
        }
    });
}

function showPendaftaranObatRacik(id){
  console.log(id);
  $.ajax({
        url: "/pendaftaran-resep-racik",
        data:{id:id},
        type: 'GET',
        success: function(res) {
          console.log(res);
            $(".racik_aturan_pakai").val(res.aturan_pakai);
            $(".racik_jumlah").val(res.jumlah_kemasan);
            $("#pendaftaran_obat_racik_id").val(res.id);
        }
    });
}

function simpanPendaftaranRacik(){
  var aturan_pakai  = $(".racik_aturan_pakai").val();
  var jumlah        = $(".racik_jumlah").val();
  var id            = $("#pendaftaran_resep_id").val();
  $.ajax({
        url: "/pendaftaran-resep-racik/"+id,
        data:{id:id,aturan_pakai:aturan_pakai,jumlah_kemasan:jumlah,"_token": "{{ csrf_token() }}"},
        type: 'PUT',
        success: function(res) {
            location.reload(); 
        }
    });
}
</script>
@endpush