
<table class="table table-bordered table-striped">
    <tr>
        <td>Pilih Periode</td>
        <td>
            {!! Form::select('periode', ['2020-10'=>'Oktober 2020'], null, ['class'=>'form-control']) !!}
        </td>
    </tr>
    <tr>
        <td></td>
        <td>
            <button type="submit" class="btn btn-danger">Tampilkan</button>
        </td>
    </tr>
</table>
<hr>
<a href="{{ url("pegawai/atur-jadwal?pegawai=$pegawai->id") }}" class="btn btn-primary" style="margin-bottom:20px">Atur Jadwal Kerja</a>
<table class="table table-bordered table-striped" id="myTable">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Shift Kerja</th>
            <th>Jam Masuk</th>
            <th>Jam Pulang</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($pegawai_shift as $shift)
        <tr>
            <td>
                <span>{{ tgl_indo($shift->tanggal) }}</span>
            </td>
            <td>
                <span>{{ $shift->shift->nama_shift }}</span>
            </td>
            <td>
                {{ $shift->shift->jam_masuk }}
            </td>
            <td>
                {{ $shift->shift->jam_pulang }}
            </td>
            <td>
                {{ Form::open(['url'=>'pegawai-shift/'.$shift->id,'method' => 'DELETE'])}}
                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                {{ Form::close() }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@push('scripts')
<script src="{{asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script>
$(document).ready( function () {
    $('#myTable').DataTable();
} );
</script>
@endpush

@push('css')
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
@endpush