<div class="form-group">
    <label class="col-sm-2 control-label">Pasien</label>
    <div class="col-sm-5">
        <input type="text" class="form-control" disabled value="{{ $nomorAntrian->pendaftaran->pasien->nama }}">
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Perusahaan Penjamin</label>
    <div class="col-sm-5">
        {!! Form::select('perusahaan_asuransi_id', $perusahaan_asuransi, null,['class'=>'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Poliklinik</label>
    <div class="col-sm-5">
        {!! Form::select('poliklinik_id', $poliklinik, null,['class'=>'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Dokter</label>
    <div class="col-sm-5">
        {!! Form::select('dokter_id', $dokter, null,['class'=>'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-danger btn btn-sm"><i class="fa fa-floppy-o" aria-hidden="true"></i> Update</button>
        <a href="/pendaftaran" class="btn btn-danger btn btn-sm"><i class="fa fa-share-square-o" aria-hidden="true"></i> Kembali</a>
    </div>
</div>