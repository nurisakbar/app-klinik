<div class="form-group">
    <label class="col-sm-2 control-label">Tanggal</label>
    <div class="col-sm-6">
        {!! Form::date('tanggal', null, ['class'=>'form-control','Placeholder'=>'Tanggal']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Keterangan</label>
    <div class="col-sm-8">
        {!! Form::text('keterangan', null, ['class'=>'form-control','Placeholder'=>'Keterangan']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Jumlah</label>
    <div class="col-sm-4">
        {!! Form::text('jumlah', null, ['class'=>'form-control','Placeholder'=>'Jumlah']) !!}
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-danger btn btn-sm"><i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan</button>
        <a href="/pengeluaran" class="btn btn-danger btn btn-sm"><i class="fa fa-share-square-o" aria-hidden="true"></i> Kembali</a>
    </div>
</div>