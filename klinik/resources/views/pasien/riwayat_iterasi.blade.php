<table class="table table-bordered" id="tabel-data">
    <thead>
        <tr>
            <th width="10">Nomor</th>
            <th>Nama Tindakan</th>
            <th>Quota</th>
            <th>Biaya</th>
            <th width="100">#</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pasien->paketIterasi as $iterasi)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $iterasi->tindakan->tindakan }}</td>
                <td>{{ $iterasi->quota }}</td>
                <th>{{ $iterasi->biaya }}</th>
                <td>
                    <button type="button" onClick="lihatRiwayatPakai({{$iterasi->id}})" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                        Lihat Riwayat
                      </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Riwayat Penggunaan Iterasi</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div id="riwayat-iterasi"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>


@push('scripts')
<script src="{{asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script>
    $(document).ready(function(){
        $('#tabel-data').DataTable();
    });


    function lihatRiwayatPakai(id){
        $.ajax({
        url: "/log-riwayat-iterasi/"+id,
        type: 'GET',
        success: function(res) {
            $("#riwayat-iterasi").html(res);
        }
    });
    }
</script>
@endpush

@push('css')
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
@endpush
