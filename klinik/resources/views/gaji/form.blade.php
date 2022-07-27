<div class="form-group">
    <label class="col-sm-2 control-label">Kode</label>
    <div class="col-sm-2">
        {!! Form::text('kode', null, ['class'=>'form-control','Placeholder'=>'Kode']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Nama</label>
    <div class="col-sm-10">
        {!! Form::text('nama', null, ['class'=>'form-control','Placeholder'=>'Nama']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Gaji Pokok</label>
    <div class="col-sm-10">
        {!! Form::number('gaji_pokok', null, ['class'=>'form-control','Placeholder'=>'Gaji Pokok']) !!}
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-danger btn btn-sm"><i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan</button>
        <a href="/pegawai" class="btn btn-danger btn btn-sm"><i class="fa fa-share-square-o" aria-hidden="true"></i> Kembali</a>
    </div>
</div>