<div class="form-group">
    <label class="col-sm-2 control-label">Kode Obat</label>
    <div class="col-sm-10">
        {!! Form::text('kode', null, ['class'=>'form-control','Placeholder'=>'Kode Obat']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Nama Obat</label>
    <div class="col-sm-10">
        {!! Form::text('nama_obat', null, ['class'=>'form-control','Placeholder'=>'Nama Obat']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Harga</label>
    <div class="col-sm-10">
        {!! Form::text('harga', null, ['class'=>'form-control','Placeholder'=>'Harga']) !!}
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Stock</label>
    <div class="col-sm-10">
        {!! Form::text('stock', null, ['class'=>'form-control','Placeholder'=>'Stock']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Status</label>
    <div class="col-sm-10">
        {!! Form::select('aktif',[1=>'Aktif',0=>'Tidak Aktif'], null, ['class'=>'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Satuan</label>
    <div class="col-sm-10">
        {!! Form::select('satuan_id',$satuan, null, ['class'=>'form-control']) !!}
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-danger btn btn-sm"><i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan</button>
        <a href="/obat" class="btn btn-danger btn btn-sm"><i class="fa fa-share-square-o" aria-hidden="true"></i> Kembali</a>
    </div>
</div>