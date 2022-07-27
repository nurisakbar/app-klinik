<h4>Daftar Tindakan Terpilih</h4>
<table class="table table-bordered">
<tr>
    <th>Nomor</th>
    <th>Nama Tindakan</th>
    <th>Action</th>
</tr>
@foreach($tindakanTemp as $tindakan)
    <tr>
        <td>{{$loop->iteration }}</td>
        <td>{{$tindakan->tindakan->tindakan}}</td>
        <td>
            <button type="button" class="btn btn-danger btn-sm" onclick="deleteTindakanTemp({{$tindakan->id}})">Delete</button>
        </td>
    </tr>
@endforeach
</table>