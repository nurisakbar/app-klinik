@extends('layouts.app')
@section('title','Kelola Data Gaji')
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Kelola Data Gaji
      <small>Daftar Gaji</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Daftar Gaji</li>
    </ol>
  </section>


  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-body">
            @include('alert')
            {!! Form::open(['url'=>'gaji','method'=>'GET']) !!}
            <table class="table table-bordered">
              <tr>
                <td width="200">Periode Gaji</td>
                <td width="200">
                  <input id="NoIconDemo" class="form-control" name="periode" type="text" value="{{$periode}}" />
                </td>
                <td>
                    <button type="submit" class="btn btn-danger btn btn-sm">Tampilkan</button>
                    <a id="export_pdf" href="/gaji/export" class="btn btn-danger btn-sm"><i class="fa fa-print"></i> Export PDF</a>
                </td>
              </tr>
            </table>
            {!! Form::close() !!}
            <hr>
            <table class="table table-bordered table-striped" id="pegawai-table">
              <thead>
                <tr>
                  <th width="10">Nomor</th>
                  <th>NIP</th>
                  <th>Nama Lengkap</th>
                  <th>Periode</th>
                  <th>Status approve</th>
                  <th>Take Home Pay</th>
                  <th width="60">#</th>
                </tr>
              </thead>
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
<script src="{{asset('adminlte/bower_components/jquery/dist/jquery-1.12.1.min.js')}}"></script>
<script src="{{asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('adminlte/bower_components/jquery-ui/jquery-ui.min.js')}}"></script>
<script src="{{asset('jquery-ui-month-picker-master/src/MonthPicker.js')}}"></script>

<script>
  $(function() {
    $('#NoIconDemo').MonthPicker({
      Button: false,
      OnAfterChooseMonth: function () {
        const period = $(this).val()
        $("#export_pdf").attr("href", "/gaji/export?periode="+ period)
      }
    });
    $("#NoIconDemo").MonthPicker('option', 'MonthFormat','yy-mm');
    
    $('#pegawai-table').DataTable({
      processing: true,
      serverSide: true,
      ajax: "/gaji?periode={{$periode}}",
      columns: [{
          data: 'DT_RowIndex',
          orderable: false,
          searchable: false
        },
        {
          data: 'pegawai.nip',
          name: 'pegawai.nip'
        },
        {
          data: 'pegawai.nama',
          name: 'pegawai.nama'
        },
        {
          data: 'periode',
          name: 'periode'
        },
        {
          data: 'status_approve',
          name: 'status_approve'
        },
        {
          data: 'take_home_pay',
          name: 'take_home_pay'
        },
        {
          data: 'action',
          name: 'action'
        }
      ]
    });
  });
</script>
@endpush

@push('css')
  <link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('adminlte/bower_components/jquery-ui/themes/smoothness/jquery-ui.css')}}">
  <link rel="stylesheet" href="{{asset('jquery-ui-month-picker-master/src/MonthPicker.css')}}">
@endpush