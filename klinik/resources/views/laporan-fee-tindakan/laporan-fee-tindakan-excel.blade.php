<table class="table table-bordered table-striped" id="users-table">
    <thead>
        <tr>
            <th width="10">Nomor</th>
            <th>Tanggal</th>
            <th>Unit</th>
            <th>Pelaksana</th>
            <th>Nama Pelaksana</th>
            <th>Nama Tindakan</th>
            <th>Fee Tindakan</th>
            <th>Biaya Tindakan</th>
            <th>Nomor Pendaftaran</th>
            <th>Nama Pasien</th>
            <th>Nomor Rekamedis</th>
            <th>Perusahaan Asuransi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $total = 0;    
        ?>
        @foreach($fees as $row)
            <?php
            $tarif_prefix = strtolower($row->jenis_pelayanan);
            if($tarif_prefix =='umum')
            {
                $tarif = $row->tarif_umum;
            }elseif($tarif_prefix=='bpjs')
            {
                $tarif = $row->tarif_bpjs;
            }else{
                $tarif = $row->tarif_perusahaan;
            }
            ?>
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$row->tanggal}}</td>
                <td>{{$row->unit??'-'}}</td>
                <td>{{$row->pelaksana}}</td>
                <td>{{$row->nama_pelaksana}}</td>
                <td>{{$row->nama_tindakan}}</td>
                <td>{{$row->jumlah_fee}}</td>
                <td>{{$tarif}}</td>
                <td>{{$row->nomor_pendaftaran}}</td>
                <td>{{$row->nama}}</td>
                <td>{{$row->nomor_rekam_medis}}</td>
                <td>{{$row->jenis_pelayanan}}</td>
            </tr>
            <?php $total += $row->jumlah_fee;?>
        @endforeach
    </tbody>
    <tr>
        <td colspan="6" style="text-align:right">Total</td>
        <td colspan="3" style="text-align:left">{{ $total }}</td>
    </tr>
</table>