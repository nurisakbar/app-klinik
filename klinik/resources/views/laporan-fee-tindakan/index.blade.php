@extends('layouts.app')
@section('title','Laporan Fee Tindakan')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Laporan Fee Tindakan
        <small>Daftar Fee Tindakan</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Laporan Fee Tindakan</li>
      </ol>
    </section>


    <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-body">
                {!! Form::open(['url'=>'laporan-fee-tindakan','method'=>'GET','id'=>'form']) !!}
                <table class="table table-bordered">
                    <tr>
                        <td width="140">Tanggal Mulai</td>
                        <td>
                            <div class="row">
                                <div class="col-md-2">
                                  {!! Form::date('tanggal_awal', $tanggal_awal, ['class'=>'form-control tanggal_awal','placeholder'=>'Tanggal Mulai']) !!}
                                </div>
                                <div class="col-md-2">
                                  {!! Form::date('tanggal_akhir', $tanggal_akhir, ['class'=>'form-control tanggal_akhir','placeholder'=>'Tanggal Mulai']) !!}
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" name="type" value="web" class="btn btn-danger"><i class="fa fa-cogs" aria-hidden="true"></i>
                                       Filter Laporan
                                    </button>
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">
                                      <i class="fa fa-table"></i> Export Excel
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
                {!! Form::close() !!}

                @include('alert')
                <table class="table table-bordered table-striped" id="fees-table">
                  <thead>
                      <tr>
                        <th width="10">Nomor</th>
                        <th>Tanggal</th>
                        <th width="200">Unit</th>
                        <th>Pelaksana</th>
                        <th>Nama Pelaksana</th>
                        <th>Nama Tindakan</th>
                        <th>Tarif Tindakan</th>
                        <th>Nomor Pendaftaran</th>
                        <th>Jenis Pelayanan</th>
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
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Export Laporan</h4>
      </div>
      {{ Form::open(['url'=>'laporan-fee-tindakan/export_excel','method' =>'get']) }}
      <div class="modal-body">
        <table class="table table-bordered">
          <tr>
            <td>Tanggal Mulai</td>
            <td>
              {{ Form::date('tanggal_mulai',null,['class'=>'form-control','placeholder'=>'Tanggal Mulai'])}}
            </td>
          </tr>
          <tr>
            <td>Tanggal Selesai</td>
            <td>
              {{ Form::date('tanggal_selesai',null,['class'=>'form-control','placeholder'=>'Tanggal Selesai'])}}
            </td>
          </tr>
          <tr>
            <td>Poliklinik</td>
            <td>
              {{Form::select('poliklinik_id',$poliklinik,null,['class'=>'form-control','placeholder'=>'-- Semua Poli --'])}}
            </td>
          </tr>
          <tr>
            <td>Nama Pelaksana</td>
            <td>
              {{Form::select('user_id',$users,null,['class'=>'form-control','placeholder'=>'-- Semua User --'])}}
            </td>
          </tr>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Export</button>
      </div>
      {{Form::close()}}
    </div>
  </div>
</div>
@endsection

@push('scripts')
<!-- DataTables -->
<script src="{{asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<!-- date-range-picker -->
<script src="{{asset('adminlte/bower_components/moment/min/moment.min.js')}}"></script>
<script src="{{asset('adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<script>
    $(function () {
		const feeDatatable = $('#fees-table').DataTable({
			processing: true,
			serverSide: true,
			ajax: {
				url : '/laporan-fee-tindakan?tanggal_awal='+$('.tanggal_awal').val()+"&tanggal_akhir="+$('.tanggal_akhir').val(),
			},
			columns: [
				{ data: 'DT_RowIndex', orderable: false, searchable: false },
				{ data: 'tanggal', name: 'tanggal' },
				{ data: 'unit', name: 'unit' },
				{ data: 'pelaksana', name: 'pelaksana' },
				{ data: 'nama_pelaksana', name: 'nama_pelaksana' },
				{ data: 'nama_tindakan', name: 'nama_tindakan' },
				{ data: 'jumlah_fee', name: 'jumlah_fee' },
				{ data: 'nomor_pendaftaran', name: 'nomor_pendaftaran' },
				{ data: 'jenis_pelayanan', name: 'jenis_pelayanan' },
			]
		});

        $('#filterDate').daterangepicker({}, function (start, end) {
                $('#filterDate span').html(start.format('D MMMM YYYY') + ' - ' + end.format('D MMMM YYYY'));
                startDate = start;
                endDate = end;
            }
		)

        $('#filterDate').on('apply.daterangepicker', function (ev, picker) {
            feeDatatable.ajax.reload()
        });
    }); 
</script>
@endpush

@push('css')
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
    <style>
      .dataTables_filter {
      display: none;
      } 
    </style>
@endpush
