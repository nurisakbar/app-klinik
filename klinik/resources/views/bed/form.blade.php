<div class="form-group">
    <label class="col-sm-2 control-label">Kamar</label>
    <div class="col-sm-10">
        {!! Form::select('kamar_id', $kamar, null, ['class'=>'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Kode Bed</label>
    <div class="col-sm-10">
        {!! Form::text('kode_bed', null, ['class'=>'form-control','Placeholder'=>'Kode Bed']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Tarif</label>
    <div class="col-sm-10">
        {!! Form::number('tarif', null, ['class'=>'form-control','Placeholder'=>'Rp.']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Status</label>
    <div class="col-sm-10">
        {!! Form::select('status', ['' => '--Pilih Status--','1' => 'Terisi','0' => 'Kosong'], null, ['class'=>'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-danger btn btn-sm"><i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan</button>
        <a href="/bed" class="btn btn-danger btn btn-sm"><i class="fa fa-share-square-o" aria-hidden="true"></i> Kembali</a>
    </div>
</div>