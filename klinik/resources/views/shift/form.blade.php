<div class="form-group">
    <label class="col-sm-2 control-label">Nama Shift</label>
    <div class="col-sm-4">
        {!! Form::text('nama_shift',null, ['class'=>'form-control','Placeholder'=>'Ex: Pagi']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Jam Masuk</label>
    <div class="col-sm-2">
        {!! Form::time('jam_masuk', null, ['class'=>'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Batas Telat Masuk</label>
    <div class="col-sm-2">
        {!! Form::time('toleransi_terlambat_masuk', null, ['class'=>'form-control','Placeholder'=>'Batas Toleransi Terlambat Masuk']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Jam Pulang</label>
    <div class="col-sm-2">
        {!! Form::time('jam_pulang', null, ['class'=>'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Batas Telat Pulang</label>
    <div class="col-sm-2">
        {!! Form::time('toleransi_terlambat_pulang', null, ['class'=>'form-control','Placeholder'=>'Batas Toleransi Terlambat Pulang']) !!}
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-danger btn btn-sm"><i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan</button>
        <a href="/shift" class="btn btn-danger btn btn-sm"><i class="fa fa-share-square-o" aria-hidden="true"></i> Kembali</a>
    </div>
</div>