<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label>Nomor Rekam Medis</label>
            @if(isset($pasien))
                <input type="text" name="nomor_rekam_medis" value="{{$pasien->nomor_rekam_medis}}" class="form-control" readonly>
            @else
                <input type="text" name="nomor_rekam_medis" value="{{generateKodeRekamMedis()}}" class="form-control" readonly>
            @endif
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Nomor Identitas *) </label>
            {!! Form::text('nomor_ktp', null, ['class'=>'form-control ktp','Placeholder'=>'Nomor KTP']) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Jenis Identitas</label>
            {{ Form::select('jenis_identitas', $jenisIdentitas, null,['class'=>'form-control']) }}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
       <div class="row">
           <div class="col-md-4">
            <div class="form-group">
                <label>Inisial</label>
                {{ Form::select('inisial', $inisial, null,['class'=>'form-control']) }}
            </div>
           </div>
           <div class="col-md-8">
            <div class="form-group">
                <label>Nama pasien *)</label>
                {!! Form::text('nama', null, ['class'=>'form-control nama_pasien','Placeholder'=>'Nama Pasien']) !!}
                @error('nama') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
           </div>
       </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Tempat Lahir *)</label>
            {!! Form::text('tempat_lahir', null, ['class'=>'form-control','Placeholder'=>'Tempat Lahir']) !!}
            @error('tempat_lahir') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Tanggal Lahir *)</label>
            <div class="row">
                <div class="col-md-7">
                    {!! Form::date('tanggal_lahir', null, ['class'=>'form-control tanggal_lahir','Placeholder'=>'Tanggal Lahir']) !!}
                    @error('tanggal_lahir') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="col-md-5">
                    <input type="text" class="form-control umur" readonly>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Jenis Kelamin</label>
            <div >
                {{Form::radio('jenis_kelamin','pria',['class'=>'form-check-input'])}}
                <label>Pria</label>
                {{Form::radio('jenis_kelamin','wanita',['class'=>'form-check-input'])}}
                <label>Wanita</label>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label>Pendidikan</label>
            {!! Form::select('pendidikan', $jenjang_pendidikan, null, ['class'=>'form-control','Placeholder'=>'Pendidikan']) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Agama</label>
            {!! Form::select('agama', $agama, null, ['class'=>'form-control']) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Status Pernikahan</label>
            {!! Form::select('status_pernikahan', $status_pernikahan, null, ['class'=>'form-control']) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Golongan Darah</label>
            {!! Form::select('golongan_darah', $golongan_darah, null, ['class'=>'form-control','Placeholder'=>'Pendidikan']) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    <label>Warganegara</label>
                    {!! Form::select('kewarganegaraan', $kewarganegaraan, null, ['class'=>'form-control']) !!}
                </div>
            </div>
            <div class="col-md-7">
                <div class="form-group">
                    <label>Suku Bangsa</label>
                    <select name="suku_bangsa" id="suku-bangsa" class="suku-bangsa form-control" style="height: 100px;" placeholder="Pilih Suku Bangsa">
                        @if(old('suku_bangsa'))
                        <option value="{{ old('suku_bangsa') }}" selected>{{ old('suku_bangsa') }}</option>
                        @endif
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label>Privilage Khusus</label>
            {!! Form::select('privilage_khusus', $privilage_khusus, null, ['class'=>'form-control']) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Jenis Pekerjaan *)</label>
            <select name="pekerjaan" id="pekerjaan" class="pekerjaan form-control" style="height: 100px;" placeholder="Pilih Jenis Pekerjaan">
                @if(old('pekerjaan'))
                <option value="{{ old('pekerjaan') }}" selected>{{ old('pekerjaan') }}</option>
                @endif
            </select>
            @error('pekerjaan') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Nomor HP *)</label>
            {!! Form::number('nomor_hp', null, ['class'=>'form-control nomor_hp','Placeholder'=>'Nomor HP']) !!}
            @error('nomor_hp') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
    </div>
</div>
<div class="row">
    @if(!isset($pasien))
    <div class="col-md-6">
        <div class="form-group">
            <label>Desa *)</label>
            <select name="wilayah_administratif" id="alamat" class="alamat form-control" style="height: 100px;" placeholder="Masukan Nama Desa">
                @if(old('wilayah_administratif'))
                <?php $data = App\Models\WilayahAdministratifIndonesia::where('village_id',old('wilayah_administratif'))->first() ?>
                <option value="{{ old('wilayah_administratif') }}" selected>{{ $data->village_name.', '.$data->district_name.', '.$data->regency_name.', '.$data->province_name }}</option>
                @endif
            </select>
            @error('wilayah_administratif') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
    </div>
    @else
    <div class="col-md-6">
        <div class="form-group">
            <label>Desa *)</label>
            @if(isset($pasien))
                @if($pasien->village_id!=null)
                <input class="form-control" disabled type="text" value="{{ $pasien->wilayahAdministratifIndonesia->province_name.','.$pasien->wilayahAdministratifIndonesia->regency_name.','.$pasien->wilayahAdministratifIndonesia->district_name.','.$pasien->wilayahAdministratifIndonesia->village_name}}">          
                @else
                <select name="wilayah_administratif" required id="alamat" class="alamat form-control" style="height: 100px;" placeholder="Masukan Nama Desa">
                    @if(old('wilayah_administratif'))
                    <?php $data = App\Models\WilayahAdministratifIndonesia::where('village_id',old('wilayah_administratif'))->first() ?>
                    <option value="{{ old('wilayah_administratif') }}" selected>{{ $data->village_name.', '.$data->district_name.', '.$data->regency_name.', '.$data->province_name }}</option>
                    @endif
                </select>
                @error('wilayah_administratif') <small class="text-danger">{{ $message }}</small> @enderror
            @endif
            
            @endif
        </div>
    </div>
    @endif
    <div class="col-md-3">
        <div class="form-group">
            <label>RT / RW *)</label>
            {!! Form::text('rt_rw', null, ['class'=>'form-control','Placeholder'=>'RT RW']) !!}
            @error('rt_rw') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Alamat Tambahan *)</label>
            {!! Form::text('alamat', null, ['class'=>'form-control','Placeholder'=>'Alamat']) !!}
            @error('alamat') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label>Nama Penanggung Jawab *)</label>
            {!! Form::text('penanggung_jawab', null, ['class'=>'form-control nama_penanggung_jawab','Placeholder'=>'Nama penanggung jawab']) !!}
            @error('penanggung_jawab') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Hubungan Dengan Pasien</label>
            {!! Form::select('hubungan_pasien', $hubungan_pasien, null, ['class'=>'form-control','Placeholder'=>'Pendidikan']) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Alamat Penanggung Jawab *)</label>
            {!! Form::text('alamat_penanggung_jawab', null, ['class'=>'form-control alamat_penanggung_jawab','Placeholder'=>'Alamat penanggung jawab']) !!}
            @error('alamat_penanggung_jawab') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Nomor HP Penanggung Jawab *)</label>
            {!! Form::text('nomor_hp_penanggung_jawab', null, ['class'=>'form-control nomor_hp_penanggung_jawab','Placeholder'=>'Nomor HP penanggung jawab']) !!}
            @error('nomor_hp_penanggung_jawab') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label>Nama Ibu Kandung *)</label>
            {!! Form::text('nama_ibu', null, ['class'=>'form-control','Placeholder'=>'Nama ibu kandung']) !!}
            @error('nama_ibu') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Penjamin</label>
            {!! Form::select('penjamin', $penjamin, null, ['class'=>'form-control penjamin','Placeholder'=>'Pendidikan','onChange'=>'cekJenisPenjamin()']) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Nomor Asuransi</label>
            {!! Form::text('nomor_asuransi', null, ['class'=>'form-control nomor_asuransi','Placeholder'=>'Nomor asuransi']) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="">Foto pasien</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>
    </div>
    <div class="col-md-5">
        <img src="https://www.riobeauty.co.uk/images/product_image_not_found.gif" id="preview" style="width: 350px;height:200px" alt="Preview Image">
    </div>
</div>
<div class="form-group">
    <div class="col-sm-10">
        <button type="submit" class="btn btn-danger btn btn-sm"><i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan</button>
        <a href="/pasien" class="btn btn-danger btn btn-sm"><i class="fa fa-share-square-o" aria-hidden="true"></i> Kembali</a>
    </div>
</div>


@push('scripts')
<script src="{{asset('adminlte/bower_components/select2/dist/js/select2.min.js')}}"></script>
<script>
$( document ).ready(function() {

    $('#image').change(function(){
        let reader = new FileReader();
        reader.onload = (e) => { 
            $('#preview').attr('src', e.target.result); 
        }
        reader.readAsDataURL(this.files[0]); 
    });

    $(".nomor_hp").keyup(function(){
        var dob = new Date($(".tanggal_lahir").val());
        var month_diff = Date.now() - dob.getTime();
        var age_dt = new Date(month_diff);   
        var year = age_dt.getUTCFullYear();
        var age = Math.abs(year - 1970);
        if(age > 17) {
            $(".nomor_hp_penanggung_jawab").val($(".nomor_hp").val());
        }
    })

    $(".ktp").keyup(function() {
        var ktp = $(".ktp").val();
        if(ktp.length==16)
        {
            var tanggal_lahir = ktp.substr(6, 2);
            var bulan_lahir   = ktp.substr(8, 2);
            var tahun_lahir   = '19' + ktp.substr(10, 2);
            if(tanggal_lahir>31)
            {
                $(".tanggal_lahir").val(tahun_lahir+'-'+bulan_lahir+'-'+(tanggal_lahir-40));
                $("[name=jenis_kelamin]").val(["wanita"]);
            }else{
                $(".tanggal_lahir").val(tahun_lahir+'-'+bulan_lahir+'-'+tanggal_lahir);
                $("[name=jenis_kelamin]").val(["pria"]);
            }

            $('.tanggal_lahir').trigger('change');
        }
    });

    $('.tanggal_lahir').bind('change', function () {
        var dob = new Date($(".tanggal_lahir").val());
        var month_diff = Date.now() - dob.getTime();
        var age_dt = new Date(month_diff);   
        var year = age_dt.getUTCFullYear();
        var age = Math.abs(year - 1970);
        $(".umur").val(age+' Tahun');
        if(age > 17) {
            $(".nama_penanggung_jawab").val($(".nama_pasien").val());
        }
    });



    

    $('.poliklinik').bind('change', function () {
        var poliklinik = $(".poliklinik").val();
        $.ajax({
            url: "/ajax/dropdown-dokter-berdasarkan-poliklinik",
            type: "get",
            data: {poliklinik:poliklinik},
            success: function(response) {
                $("#dokter").html(response);
        }});
    });

    $('.poliklinik').trigger('change');

    $('.alamat').select2({
        placeholder: 'Cari Nama Desa',
        ajax: {
        url: '/ajax/select2Desa',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
            return {
            results:  $.map(data, function (item) {
                return {
                text: item.village_name,
                id: item.village_id
                }
            })
            };
        },
        cache: true
        }
    });

    $(".alamat").on("select2:select", function (e) { 
        var select_val = $(e.currentTarget).text();
        var dob = new Date($(".tanggal_lahir").val());
        var month_diff = Date.now() - dob.getTime();
        var age_dt = new Date(month_diff);   
        var year = age_dt.getUTCFullYear();
        var age = Math.abs(year - 1970);
        if(age > 17) {
            $(".alamat_penanggung_jawab").val(select_val.trim());
        }
    });


    $('.pekerjaan').select2({
        placeholder: 'Pilih Jenis Pekerjaan',
        ajax: {
        url: '/ajax/select2Pekerjaan',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
            return {
            results:  $.map(data, function (item) {
                return {
                text: item,
                id: item
                }
            })
            };
        },
        cache: true
        }
    });

    $('.suku-bangsa').select2({
        placeholder: 'Pilih Suku Bangsa',
        ajax: {
        url: '/ajax/select2SukuBangsa',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
            return {
            results:  $.map(data, function (item) {
                return {
                text: item,
                id: item
                }
            })
            };
        },
        cache: true
        }
    });
});

function cekJenisPenjamin(){
    var penjamin = $(".penjamin").val();
    if(penjamin==2){
        $(".nomor_asuransi").attr("required","required");
    }
}
</script>
@endpush

@push('css')
    <link href="{{asset('adminlte/bower_components/select2/dist/css/select2.min.css')}}" rel="stylesheet"/>
@endpush