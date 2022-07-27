<div class="form-group">
    <label class="col-sm-2 control-label">Kode Tindakan</label>
    <div class="col-sm-4">
        <select name="kode" id="kode" class="select2 form-control">
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Nama Tindakan</label>
    <div class="col-sm-10">
        {!! Form::text('tindakan', null, ['class'=>'form-control','Placeholder'=>'Nama Tindakan']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Jenis Tindakan</label>
    <div class="col-sm-10">
        {!! Form::select('jenis', config('datareferensi.jenis_tindakan'), null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Poliklinik</label>
    <div class="col-sm-5">
        {!! Form::select('poliklinik_id',$poliklinik, null, ['class'=>'form-control','Placeholder'=>'Nama Tindakan']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Tarif</label>
    <div class="col-sm-3">
        {!! Form::text('tarif_umum', null, ['class'=>'form-control','Placeholder'=>'Tarif Umum']) !!}
    </div>
    <div class="col-sm-3">
        {!! Form::text('tarif_perusahaan', null, ['class'=>'form-control','Placeholder'=>'Tarif Perusahaan']) !!}
    </div>
    <div class="col-sm-3">
        {!! Form::text('tarif_bpjs', null, ['class'=>'form-control','Placeholder'=>'Tarif BPJS']) !!}
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Tindakan Iterasi</label>
    <div class="col-sm-2">
        {!! Form::select('iterasi',[1=>'Ya',0=>'Tidak'], null, ['class'=>'form-control iterasi','onChange'=>'apakah_iterasi()']) !!}
    </div>
    <div class="col-sm-1">
        {!! Form::text('quota', null, ['class'=>'form-control quota','Placeholder'=>'Quota']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Pelayanan</label>
    <div class="col-sm-2">
        {!! Form::select('pelayanan',['umum'=>'Umum','bpjs'=>'BPJS'], null, ['class'=>'form-control']) !!}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Penunjang</label>
    <div class="col-sm-2">
        {!! Form::select('penunjang',[1=>'Ya',0=>'Tidak'], null, ['class'=>'form-control']) !!}
    </div>
</div>
<hr>
<div class="form-group">
    <label class="col-sm-2 control-label"></label>
    <div class="row">
        @foreach($jenis as $j)
            <div class="col-md-3">
                @foreach($object as $row => $key)
                <div class="form-group">
                    <label>Fee {{ $key }} untuk Tarif {{ $j }}</label>
                    <div class="row">
                        <div class="col-md-10">
                            @if(isset($tindakan))
                                {!! Form::text('pembagian_tarif['.$row.'-'.$j.']', null, ['class'=>'form-control','required'=>'required','Placeholder'=>'Masukan Tarif ...']) !!}
                            @else
                                <input name="pembagian_tarif[{{ $row.'-'.$j }}]" value="0" type="text" class="form-control" placeholder="Masukan Tarif ...">
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-danger btn btn-sm"><i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan</button>
        <a href="/tindakan" class="btn btn-danger btn btn-sm"><i class="fa fa-share-square-o" aria-hidden="true"></i> Kembali</a>
    </div>
</div>

@push('css')
<link href="{{asset('/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
@endpush


@push('scripts')
<!-- DataTables -->
<script src="{{asset('adminlte/bower_components/select2/dist/js/select2.min.js')}}"></script>
<script src="{{asset('datatables/datatables.min.js') }}"></script>

<script>
        $(function() {
            apakah_iterasi();
        });


    function apakah_iterasi(){
        var iterasi = $(".iterasi").val();
        if(iterasi=='0')
        {
            $(".quota").val(0);
            $(".quota").attr('disabled','disabled');
        }else{
            $('.quota').removeAttr("disabled")
        }
    }
    $('#kode').select2({
        placeholder: 'Cari Kode Nine',
        multiple: false,
        ajax: {
            url: '/ajax/select2ICDNine',
            dataType: 'json',
            delay: 250,
            multiple: false,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.code + ' - ' +item.desc_short,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });
</script>
@endpush
