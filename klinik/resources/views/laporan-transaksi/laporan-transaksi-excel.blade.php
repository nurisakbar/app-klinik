<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Kode Pendaftaran</th>
            <th>Nomor RM</th>
            <th>Nama Pasien</th>
            <th>Jenis Layanan</th>
            <th>Total Transaksi</th>
            <th>Biaya Tambahan</th>
            <th>Subtotal</th>
            <th>Jenis Pembayaran</th>
            <th>Nama Kasir</th>
        </tr>
    </thead>
    <tbody>
        @php 
            $total = null;
            $total_looping = $jumlah_pendaftaran - $laporan_transaksi->count()
        @endphp
        
        @foreach($nomorAntrian->get() as $laporan)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ substr($laporan->created_at,0,16) }}</td>
            <td>{{ $laporan->kode }}</td>
            <td>{{ $laporan->nomor_rekam_medis }}</td>
            <td>{{ $laporan->nama }}</td>
            <td>{{ $laporan->nama_perusahaan }}</td>
            <td>{{ $laporan->total_bayar }}</td>
            <td>{{ $laporan->biaya_tambahan }}</td>
            <td>{{ $laporan->biaya_tambahan+$laporan->total_bayar }}</td>
            <td>{{ $laporan->metode_pembayaran }}</td>
            <td>{{ $laporan->nama_kasir??'-' }}</td>
        </tr>
        @php 
            $total += $laporan->total_bayar+$laporan->biaya_tambahan;
        @endphp
        @endforeach

        <tr>
            <th colspan="7"></th>
            <th>TOTAL</th>
            <th colspan="3" style="text-align:left">{{ $total }}</th>
        </tr>
    </tbody>
</table>