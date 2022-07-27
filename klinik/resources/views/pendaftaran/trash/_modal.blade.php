<!-- Modal Diagnosa Pasien-->
<div class="modal fade" id="modalDiagnosa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div class="row">
            <div class="col-md-6">
              <h5 class="modal-title" id="exampleModalLabel">Daftar Diagnosa Pasien</h5>
            </div>
            <div class="col-md-6 text-right">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          </div>
        </div>
        <div class="modal-body">
         <table class="table table-bordered table-striped" id="basic-datatables">
          <thead>
            <tr>
              <th scope="col">Nomor</th>
              <th scope="col">Kode</th>
              <th scope="col">Nama Diagnosa</th>
              <th scope="col">#</th>
            </tr>
          </thead>
          <tbody>
            @foreach($diagnosa as $row)
              <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $row->kode }}</td>
                <td>{{ $row->nama }}</td>
                <td><button class="btn btn-primary btn-sm pilih-diagnosa" data-id="{{ $row->id }}">Pilih</button></td>
              </tr>
              @endforeach
          </tbody>
        </table>
        </div>
      </div>
    </div>
  </div>


  <!-- Modal Resep Pasien -->
<div class="modal fade" id="modalResep" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <div class="row">
          <div class="col-md-6">
            <h5 class="modal-title" id="exampleModalLabel">Daftar Resep Pasien</h5>
          </div>
          <div class="col-md-6 text-right">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        </div>
      </div>
      <div class="modal-body">
          <table class="table table-bordered table-striped" id="basic-datatables-obat">
            <thead>
              <tr>
                <th scope="col">Nomor</th>
                <th scope="col">Kode</th>
                <th scope="col">Nama Obat</th>
                <th scope="col">#</th>
              </tr>
            </thead>
            <tbody>
              @foreach($obat as $row)
                <tr>
                  <th scope="row">{{ $loop->iteration }}</th>
                  <td>{{ $row->kode }}</td>
                  <td>{{ $row->nama_obat }}</td>
                  <td><button class="btn btn-primary btn-sm pilih-obat" data-id="{{ $row->id }}">Pilih</button></td>
                </tr>
                @endforeach
            </tbody>
          </table>
      </div>
    </div>
  </div>
</div>


<!-- Modal Resep Obat Selanjutnya-->
<div class="modal fade" id="modalResepNext" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
            <div class="row">
              <div class="col-md-6">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-arrow-left return-pilih-obat"></i> Daftar Resep Pasien / <label class="kode-obat"></label></h5>
              </div>
              <div class="col-md-6 text-right">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            </div>
      </div>
      <div class="modal-body">
        <div class="form-group">
          {{ Form::hidden('jenis_resume_id', null,['id' => 'data-jenis-resume-id']) }}
          <label for="exampleFormControlInput1">Jumlah Obat</label>
          <input type="number" class="form-control" id="jumlah-obat" placeholder="0">
        </div>
        <div class="form-group">
          <label for="exampleFormControlInput">Aturan Pakai</label>
          <input type="text" class="form-control" id="aturan-pakai" placeholder="EX : 2x1">
        </div>
      </div>
      <div class="modal-footer text-right">
        <button type="button" class="btn btn-success btn-sm tambah-obat">Tambahkan</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal Tindakan-->
<div class="modal fade" id="modalTindakan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <div class="row">
          <div class="col-md-6">
            <h5 class="modal-title" id="exampleModalLabel">Daftar Tindakan</h5>
          </div>
          <div class="col-md-6 text-right">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        </div>
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-striped" id="basic-datatables-tindakan">
          <thead>
            <tr>
              <th scope="col">Nomor</th>
              <th scope="col">Kode</th>
              <th scope="col">Nama Tindakan</th>
              <th scope="col">#</th>
            </tr>
          </thead>
          <tbody>
            @foreach($tindakan as $row)
              <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $row->kode }}</td>
                <td>{{ $row->tindakan }}</td>
                <td><button class="btn btn-primary btn-sm pilih-tindakan" data-id="{{ $row->id }}">Pilih</button></td>
              </tr>
              @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>