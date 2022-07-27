<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box card-height">
                <div class="box-header card-header">
                    <strong>Informasi Pasien</strong>

                </div>
                <div class="box-body">
                    <div class="row">

                        <div class="card-spac">
                            <div class="col-md-5">
                                <strong>Nomor Pendaftaran</strong>
                            </div>
                            <div class="col-md-7">
                                : {{ $pendaftaran->kode }}
                            </div>
                        </div>

                        <div class="card-spac">
                            <div class="col-md-5">
                                <strong>Nama</strong>
                            </div>
                            <div class="col-md-7">
                                : {{ $pendaftaran->pasien->nama }}
                            </div>
                        </div>

                        <div class="card-spac">
                            <div class="col-md-5">
                                <strong>Tempat tgl lahir</strong>
                            </div>
                            <div class="col-md-7">
                                : {{ $pendaftaran->pasien->tempat_lahir }},
                                {{ tgl_indo($pendaftaran->pasien->tanggal_lahir) }}
                            </div>
                        </div>

                        <div class="card-spac">
                            <div class="col-md-5">
                                <strong>Umur</strong>
                            </div>
                            <div class="col-md-7">
                                : {{ hitung_umur($pendaftaran->pasien->tanggal_lahir) }} tahun
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="box card-height">
                <div class="box-header card-header">
                    <strong>Informasi Terkait</strong>

                </div>
                <div class="box-body">
                    <div class="row">

                        <div class="card-spac">
                            <div class="col-md-5">
                                <strong>Tujuan Poliklinik</strong>
                            </div>
                            <div class="col-md-7">
                                : {{ $pendaftaran->nomorAntrian??'-' }}
                            </div>
                        </div>

                        <div class="card-spac">
                            <div class="col-md-5">
                                <strong>Tanggal Sekarang</strong>
                            </div>
                            <div class="col-md-7">
                                : {{ tgl_indo(date('Y-m-d')) }}
                            </div>
                        </div>

                        <div class="card-spac">
                            <div class="col-md-5">
                                <strong>Jenis Layanan</strong>
                            </div>
                            <div class="col-md-7">
                                : {{ $pendaftaran->perusahaanAsuransi->nama_perusahaan }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>