<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#komponen-modal">
    <i class="fa fa-plus"></i> Tambah Komponen Gaji
</button>
<hr>
<table class="table table-bordered table-striped" id="komponen-gaji-table">
    <thead>
        <tr>
            <th width="20px">Nomor</th>
            <th>Komponen Gaji</th>
            <th>Jumlah</th>
            <th>Keterangan</th>
            <th>Action</th>
        </tr>
    </thead>
</table>


@push('scripts')
<script src="{{asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script>
$(document).ready( function () {
  $(function() {
    $('#komponen-gaji-table').DataTable({
      processing: true,
      serverSide: true,
      ajax: '/tunjangan-gaji?pegawai_id=' + {{ $pegawai->id }} +'',
      columns: [{
          data: 'DT_RowIndex',
          orderable: false,
          searchable: false
        },
        {
          data: 'komponen_gaji.nama_komponen',
          name: 'komponen_gaji.nama_komponen'
        },
        {
          data: 'jumlah',
          name: 'jumlah'
        },
        {
          data: 'keterangan',
          name: 'keterangan'
        },
        {
          data: 'action',
          name: 'action'
        }
      ]
    });
  });
} );
</script>
@endpush

@push('css')
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
@endpush
