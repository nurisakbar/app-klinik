@extends('layouts.app')
@section('title','Daftar Neraca Saldo')
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Neraca Saldo
      <small>Daftar Neraca Saldo</small>
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
            @include('validation_error')
            <hr>
            @include('alert')
            {!! Form::open(['url'=>'neraca-saldo','method'=>'GET']) !!}
            <table class="table table-bordered">
              <tr>
                <td width="290">Periode</td>
                <td>
                  <input class="form-control" id="NoIconDemo" name="periode" type="month" value="{{$periode}}" />
                </td>
              </tr>
              <tr>
                <td></td>
                <td>
                  <button type="submit" name="action" value="filter" class="btn btn-danger btn btn-sm">Tampilkan</button>
                  <button type="submit" name="action" value="download" class="btn btn-success btn btn-sm"><i class="fa fa-download"></i> Download Excel</button>
                </td>
              </tr>
            </table>
            {!! Form::close() !!}
            <table class="table table-bordered table-striped" id="users-table">
              <thead>
                <tr>
                  <th width="10">Nomor</th>
                  <th>Kode</th>
                  <th>Nama Akun</th>
                  <th>Kredit</th>
                  <th>Debet</th>
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
<script src="{{asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('adminlte/bower_components/jquery-ui/jquery-ui.min.js')}}"></script>
<script src="{{asset('jquery-ui-month-picker-master/src/MonthPicker.js')}}"></script>
<script>
  $(function() {
    $('#NoIconDemo').MonthPicker({ Button: false });
    $("#NoIconDemo").MonthPicker('option', 'MonthFormat','yy-mm');

    $('#users-table').DataTable({
      processing: true,
      serverSide: true,
      ajax: '/neraca-saldo?periode={{$periode}}',
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
          data: 'akun',
          name: 'akun'
        },
        {
          data: 'kredit',
          name: 'kredit'
        },
        {
          data: 'debet',
          name: 'debet'
        },
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