<div class="form-group">
    <label class="col-sm-2 control-label">Kode Kamar</label>
    <div class="col-sm-2">
        {!! Form::text('kode_kamar', null, ['class'=>'form-control','Placeholder'=>'Kode Kamar']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Nama Kamar</label>
    <div class="col-sm-10">
        {!! Form::text('nama_kamar', null, ['class'=>'form-control','Placeholder'=>'Nama Kamar']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Kelas</label>
    <div class="col-sm-10">
        {!! Form::select('kelas', ['' => '--Pilih Kelas--','kelas 1' => 'Kelas 1','kelas 2' => 'Kelas 2'], null, ['class'=>'form-control','Placeholder'=>'Keterangan']) !!}
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-danger btn btn-sm"><i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan</button>
        <a href="/kamar" class="btn btn-danger btn btn-sm"><i class="fa fa-share-square-o" aria-hidden="true"></i> Kembali</a>
    </div>
</div>