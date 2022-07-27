<div class="form-group">
    <label class="col-sm-2 control-label">Nama Komponen</label>
    <div class="col-sm-10">
        {!! Form::text('nama_komponen', null, ['class'=>'form-control','Placeholder'=>'Nama Komponen']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Keterangan</label>
    <div class="col-sm-10">
        {!! Form::text('keterangan', null, ['class'=>'form-control','Placeholder'=>'Keterangan']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Jenis</label>
    <div class="col-sm-3">
        {!! Form::select('jenis',['penambah'=>'Penambah','pengurang'=>'Pengurang'], null, ['class'=>'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-danger btn btn-sm"><i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan</button>
        <a href="/obat" class="btn btn-danger btn btn-sm"><i class="fa fa-share-square-o" aria-hidden="true"></i> Kembali</a>
    </div>
</div>
