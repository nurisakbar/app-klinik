<div class="form-group">
    <label class="col-sm-2 control-label">Tanggal</label>
    <div class="col-sm-2">
        {!! Form::date('tanggal[]', null, ['class'=>'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Akun</label>
    <div class="col-sm-10">
        {!! Form::select('akun_id[]', $akunList, null, ['class'=>'form-control akun','Placeholder'=>'Akun']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Nominal Rp.</label>
    <div class="col-sm-10">
        {!! Form::number('nominal[]', null, ['class'=>'form-control','Placeholder'=>'Nominal']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Keterangan</label>
    <div class="col-sm-10">
        {!! Form::text('keterangan[]', null, ['class'=>'form-control','Placeholder'=>'Keterangan']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Tipe</label>
    <div class="col-sm-10">
        {!! Form::select('tipe[]', ['debet' => 'DEBET', 'kredit' => 'KREDIT'],null, ['class' => 'form-control']); !!}
    </div>
</div>
<hr>
<div class="form-group">
    <label class="col-sm-2 control-label">Tanggal</label>
    <div class="col-sm-2">
        {!! Form::date('tanggal[]', null, ['class'=>'form-control']) !!}
    </div>
    <div class="col-sm-2" style="float:right">
        <button type="button" class="btn btn-danger" onclick="copy_form()">
            <i class="fa fa-plus-square" aria-hidden="true"></i> Tambah Form
        </button>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Akun</label>
    <div class="col-sm-10">
        {!! Form::select('akun_id[]', $akunList, null, ['class'=>'form-control akun','Placeholder'=>'Akun']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Nominal Rp.</label>
    <div class="col-sm-10">
        {!! Form::number('nominal[]', null, ['class'=>'form-control','Placeholder'=>'Nominal']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Keterangan</label>
    <div class="col-sm-10">
        {!! Form::text('keterangan[]', null, ['class'=>'form-control','Placeholder'=>'Keterangan']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Tipe</label>
    <div class="col-sm-10">
        {!! Form::select('tipe[]', ['debet' => 'DEBET', 'kredit' => 'KREDIT'],null, ['class' => 'form-control']); !!}
    </div>
</div>
<div class="new"></div>
<input type="hidden" name="periode" class="form-control" value="{{$periode}}">
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-danger btn btn-sm"><i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan</button>
        <a href="/jurnal" class="btn btn-danger btn btn-sm"><i class="fa fa-share-square-o" aria-hidden="true"></i> Kembali</a>
    </div>
</div>