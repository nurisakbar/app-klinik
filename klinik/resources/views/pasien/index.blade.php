@extends('layouts.app')
@section('title','Kelola Data Pasien')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Kelola Data Pasien
        <small>Daftar Pasien</small>
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
                  <a href="{{route('pasien.create')}}" class="btn btn-info btn-social btn-flat">
                    <i class="fa fa-plus-square-o" aria-hidden="true"></i>Pendaftaran Pasien Baru</a>
                  <a href="{{route('pendaftaran.create')}}" class="btn btn-success btn-social btn-flat">
                      <i class="fa fa-plus-square-o" aria-hidden="true"></i>Pendaftaran Pasien Lama</a>
                  {{-- <button type="button" class="btn btn-warning btn-social btn-flat" data-toggle="modal" data-target="#modal-default">
                    <i class="fa fa-list"></i> Riwayat Kunjungan
                  </button>
                  <button type="button" class="btn btn-primary btn-social btn-flat" data-toggle="modal" data-target="#myModal">
                    <i class="fa fa-file-excel-o" aria-hidden="true"></i> Import Data
                  </button> --}}
                  <hr>
                @include('alert')
              <table class="table table-bordered table-striped" id="users-table">
                  <thead>
                      <tr>
                        <th width="10">Nomor</th>
                        <th>Nomor KTP</th>
                        <th>Nomor Rekam Medis</th>
                        <th>Nama Pasien</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th width="85">#</th>
                      </tr>
                  </thead>
              </table>
              </div>
            </div>
          </div>
        </div>
      </section>
  </div>
  {{-- <div class="modal fade modal-xl" id="modal-default">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Daftar Riwayat Kunjungan</h4>
        </div>
        <div class="modal-body">
          <table class="table table-bordered table-striped">
            <thead>
                <tr>
                  <th width="10">No</th>
                  <th>Nomor Pendaftaran</th>
                  <th>Tanggal</th>
                  <th>Poliklinik Tujuan</th>
                  <th>Dokter</th>
                  <th>Jenis Layanan</th>
                </tr>
            </thead>
            <tbody>
              @foreach($pendaftaran as $p)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td><button class="badge badge-success kode" data-kode="{{ $p->id }}">{{ $p->kode }}</button></td>
                <td>{{ substr($p->created_at, 0, 10) }}</td>
                <td>{{ $p->poliklinik->nama??'-' }}</td>
                <td>{{ $p->dokter->name??'-' }}</td>
                <td>{{ $p->perusahaanAsuransi->nama_perusahaan }}</td>
              </tr>
              @endforeach
            </tbody>
        </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div> --}}
  <!-- /.modal -->
  <div class="modal fade" id="modal-detail">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header" style="background-color: rgb(197, 197, 28)">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Riwayat Kunjungan Pasien</h4>
        </div>
        <div class="modal-body">
          <table class="table table-bordered table-striped">
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
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->



  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Import Data Pasien</h4>
        </div>
        {{ Form::open(['url'=>'pasien/import','files'=>true]) }}
        <div class="modal-body">
  
          <div class="alert alert-info" role="alert">Download Template Import <a href="{{ asset('template_import_barang.xlsx')}}">Disini</a></div>
         <table class="table table-bordered">
           <tr>
             <td>Pilih FIle</td>
             <td>
               {{ Form::file('file')}}
             </td>
           </tr>
         </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Upload</button>
        </div>
        {{ Form::close() }}
      </div>
    </div>
  </div>


@endsection

@push('scripts')
<!-- DataTables -->
<script src="{{asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script>
    $(function() {
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/pasien',
            columns: [
                {data: 'DT_RowIndex', orderable: false, searchable: false},
                { data: 'nomor_ktp', name: 'nomor_ktp' },
                { data: 'nomor_rekam_medis', name: 'nomor_rekam_medis' },
                { data: 'nama', name: 'nama' },
                { data: 'tempat_lahir', name: 'tempat_lahir' },
                { data: 'tanggal_lahir', name: 'tanggal_lahir' },
                { data: 'action', name: 'action' }
            ]
        });

        // $('.kode').on('click', function() {
        //   let idPendaftaran = $(this).attr('data-kode')
        //   $.ajax({
        //     url: "pasien/riwayatKunjungan/" + idPendaftaran,
        //     type: "GET",
        //     success: function(res) {
        //       let obat = []
        //       let tindakan = []
        //       let diagnosa = []

        //       res.obat.forEach(function(el) {
        //         obat.push(el.barang.nama_barang)
        //       })

        //       res.diagnosa.forEach(function(el) {
        //         diagnosa.push(el.icd.indonesia)
        //       })

        //       res.tindakan.forEach(function(el) {
        //         tindakan.push(el.tindakan.tindakan)
        //       })

        //       $('#pasien').html(res.pasien)
        //       $('#diagnosa').html(diagnosa.join(", "))
        //       $('#tindakan').html(tindakan.join(", "))
        //       $('#obat').html(obat.join(", "))

        //       $('#modal-detail').modal('show')
        //     },
        //     error: function(err) {
        //       console.log(err);
        //     }
        //   })
        // })
    });
</script>
@endpush

@push('css')
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
@endpush
