<div class="wraper-{{$id}}">
<hr>
<div class="form-group">
    <label class="col-sm-2 control-label">Tanggal</label>
    <div class="col-sm-2">
        {!! Form::date('tanggal[]', null, ['class'=>'form-control']) !!}
    </div>
    <div class="col-sm-2" style="float:right">
        <button type="button" class="btn btn-danger" onclick="hapus_form({{$id}})">
            <i class="fa fa-trash" aria-hidden="true"></i> Hapus Form
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
</div>