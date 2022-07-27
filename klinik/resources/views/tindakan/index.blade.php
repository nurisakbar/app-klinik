@extends('layouts.app')
@section('title','Kelola Tindakan')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Kelola Data Tindakan
        <small>Daftar Tindakan</small>
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
                  <a href="{{route('tindakan.create')}}" class="btn btn-info btn-social btn-flat"><i class="fa fa-plus-square-o" aria-hidden="true"></i>
                     Tambah Data</a>
                     <button type="button" class="btn btn-primary btn-social btn-flat" data-toggle="modal" data-target="#myModal">
                      <i class="fa fa-file-excel-o" aria-hidden="true"></i> Import Tindakan
                    </button>
                    <a href="{{route('tindakan.excel')}}" class="btn btn-info btn-social btn-flat"><i class="fa fa-plus-square-o" aria-hidden="true"></i>
                      Export Excel</a>
                  <hr>
                
                @include('alert')
                <table class="table table-bordered table-striped" id="users-table">
                  <thead>
                      <tr>
                        <th width="10">Nomor</th>
                        <th>Kode ICD 9</th>
                        <th>Nama Tindakan</th>
                        <th>Jenis Tindakan</th>
                        <th>Tarif Umum</th>
                        <th>Tarif BPJS</th>
                        <th>Tarif Perusahaan</th>
                        <th>Pelayanan</th>
                        <th>Poliklinik</th>
                        <th width="100">#</th>
                      </tr>
                  </thead>
              </table>
              </div>
            </div>
          </div>
        </div>
      </section>
  </div>

    <!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    {{ Form::open(['url'=>'tindakan/import','files'=>true]) }}
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Import Data Tindakan</h4>
      </div>
      <div class="modal-body">
        <div class="alert alert-success" role="alert">Download Template Import Tindakan <a href="/template_import_tindakan_bhp.xlsx"><b>Disini</b></a></div>
        <table class="table table-bordered">
          <tr>
            <td>Pilih File</td>
            <td><input type="file" name="file" accept=".xlsx"></td>
          </tr>
          <tr>
            <td>Kosongkan Data Sebelumnya ?</td>
            <td>
              <select name="kosongkan" class="form-control">
                <option value="0">Tidak</option>
                <option value="1">Ya</option>
              </select>
            </td>
          </tr>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Upload & Proses</button>
      </div>
    </div>
    {{ Form::close() }}
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
            ajax: '/tindakan',
            columns: [
                {data: 'DT_RowIndex', orderable: false, searchable: false},
                { data: 'kode', name: 'kode' },
                { data: 'tindakan', name: 'tindakan' },
                { data: 'jenis', name: 'jenis' },
                { data: 'tarif_umum', name: 'harga' },
                { data: 'tarif_bpjs', name: 'tarif_bpjs' },
                { data: 'tarif_perusahaan', name: 'tarif_perusahaan' },
                { data: 'pelayanan', name: 'pelayanan' },
                { data: 'poliklinik.nama', name: 'poliklinik.nama' },
                { data: 'action', name: 'action' }
            ]
        });
    });
</script>
@endpush

@push('css')
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
@endpush
