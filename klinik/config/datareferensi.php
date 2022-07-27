<?php


return [
    // data referensi kelompok pegawai
    'kelompok_pegawai'     =>   [
        'dokter'                => 'Dokter',
        'perawat'               => 'Perawat',
        'administrasi'          => 'Administrasi',
        'penunjang medis'       => 'Penunjang Medis',
        'security'              => 'Security',
        'non medis'             => 'Non Medis',
        'bidan'                 => 'Bidan',
        'dokter radioterapi'    => 'Dokter Radioterapi',
        'farmasi'               => 'Farmasi',
        'dokter luar'           => 'Dokter Luar',
        'terapis'               => 'Terapis',
        'supir'                 => 'Supir',
        'radiografer'           => 'Radiografer',
        'direkur'               => 'Direkur',
        'keuangan'              => 'Keuangan',
    ],

    // data referensi agama
    'agama'                 => [
        'islam'                 => 'Islam',
        'protestan'             => 'Protestan',
        'katolik'               => 'Katolik',
        'hindu'                 => 'Hindu',
        'buddha'                => 'Buddha',
        'khonghucu'             => 'Khonghucu',

    ],

    // data referensi jenjang pendidikan
    'jenjang_pendidikan'    => [
        'TK'                    => 'TK',
        'SD'                    => 'SD',
        'SMP'                   => 'SMP',
        'SMA/SMK/SMU'           => 'SMA/SMK/SMU',
        'Perguruan Tinggi'      => 'Perguruan Tinggi',
    ],

    'status_pernikahan'    => [
        'sudah menikah'         => 'Sudah Menikah',
        'belum menikah'         => 'Belum Menikah',
    ],
    'kewarganegaraan'    => [
        'WNI'         => 'WNI',
        'WNA'         => 'WNA',
    ],

    'golongan_darah'    => [
        '-'         => 'Belum Diperiksa',
        'A'         => 'A',
        'B'         => 'B',
        'AB'        => 'AB',
        'O'         => 'O',
    ],

    'privilage_khusus'    => [
        'tidak'         => 'TIDAK',
        'tunanetra'     => 'Tunanetra',
        'tunarungu'     => 'Tunarungu',
        'tunawicara'    => 'Tunawicara',
        'tunadaksa'     => 'Tunadaksa',
        'tunagrahita'   => 'Tunagrahita',
        'tunalaras'     => 'Tunalaras',
        'autis'         => 'Autis',
    ],

    'hubungan_pasien'   => [
        'pasien'        => 'PASIEN',
        'istri'         => 'ISTRI',
        'suami'         => 'SUAMI',
        'ayah'          => 'AYAH',
        'ibu'           => 'IBU',
        'anak'          => 'ANAK',
        'saudara'       => 'SAUDARA'
    ],

    'status_kehadiran'    => [
        'hadir'        => 'Hadir',
        'tidak hadir'  => 'Tidak Hadir',
        'izin'         => 'Izin',
        'sakit'        => ' Sakit',
        'cuti'         => 'Cuti',
        'terlambat'    => 'Terlambat',
        'default'      => 'Defaults',
    ],

    'status_pelayanan' => [
        'pendaftaran' => 'Pendaftaran',
        'batal' => 'Batal',
        'selesai'=>'Selesai Pelayanan',
        'pemeriksaan_laboratorium' => 'Rujukan Laboratorium',
        'selesai_pemeriksaan_medis' => 'Pemeriksaan Medis',
        'selesai_pelayanan' => 'Selesai Pelayanan',
        'selesai_pembayaran'=>'Selesai Pembayaran',
        'sedang_dirujuk'     => 'Sedang Dirujuk'
    ],


    'user_role'            => [
        'administrator' =>  'Administrator',
        'pimpinan'      =>  'Pimpinan',
        'dokter'        =>  'Dokter',
        'kasir'         =>  'Kasir',
        'keuangan'      =>  'Keuangan',
        'akutansi'      => 'Akutansi',
        'hrd'           =>  'HRD',
        'apoteker'      => 'Apoteker',
        'poliklinik'      =>  'Poliklinik',
        'bagian_pendaftaran' => 'Bagian Pendaftaran',
        'admin_medis'   =>  'Admin Medis',
        'rekamedis'     =>'Rekamedis',
        'bagian_gudang' => 'Bagian Gudang'
    ],

    'jenis_barang'          => [
        'obat'  =>  'Obat',
        'alkes' =>  'Alkes'
    ],

    'jenis_tindakan'          => [
        'tindakan_medis'  =>  'Tindakan Medis',
        'tindakan_laboratorium' =>  'Tindakan Laboratorium'
    ],

    'hari'                  => [
        'Monday'        => 'Senin',
        'Tuesday'       => 'Selasa',
        'Wednesday'     => 'Rabu',
        'Thursday'      => 'kamis',
        'Friday'        => 'Jumat',
        'Saturday'      => 'Sabtu',
        'Sunday'        => 'Minggu'
    ],

    'jenis_kategori'        => [
        'obat_alkes'    =>  'Obat Dan Alkes',
        'tindakan'      =>  'Tindakan'
    ],

    'kelompok_pasien' => [
        'umum'      =>  'Umum',
        'non_umum'  =>  'Non Umum'
    ],

    'status_po' => [
        'pengajuan_po'          =>  'Pengajuan Purchase Order',
        'menunggu_persetujuan'  =>  'Menunggu Persetujuan',
        'approve_by_pimpinan'   =>  'Approve Oleh Pimpinan',
        'reject_by_pimpinan'    =>  'Ditolak Oleh Pimpinan',
        'selesai_po'            =>  'Selesai'
    ],

    'jenis_pendaftaran' => [
        'daftar langsung' => 'DAFTAR LANGSUNG',
        'via telepon'     => 'VIA TELEPON'
    ],

    'jenis_rujukan'     => [
        'datang sendiri'    => 'DATANG SENDIRI',
        'puskesmas'         => 'PUSKESMAS',
        'rumah sakit luar'  => 'RUMAH SAKIT LUAR',
        'dokter luar'       => 'DOKTER LUAR',
        'bidan'             => 'BIDAN',
        'faskes lainnya'    => 'FASKES LAINNYA',
        'rujukan non medis' => 'RUJUKAN NON MEDIS'
    ],

    'inisial'       => [
        'Tn.'   => 'Tn.',
        'Ny.'   => 'Ny.',
        'Nn.'   => 'Nn.',
        'Anak'  => 'Anak'
    ],

    'jenis_identitas'       => [
        'KTP'            => 'KTP',
        'Passport'       => 'Passport',
        'Kartu Keluarga' => 'Kartu',
        'DLL'            => 'DLL'
    ],


    // digunakan pada module tindakan
    'object_fee' => [
        'klinik'            =>  'Klinik',
        'dokter'            =>  'Dokter',
        'asisten'           =>  'Asisten'
    ],

    'bank' => [
        'BCA'      => 'BCA',
        'BRI'      => 'BRI',
        'MANDIRI'  => 'MANDIRI',
        'BNI'      => 'BNI',
        'BTN'      => 'BTN'
    ],

    'jenis_pekerjaan' => [
        'Karyawan Swasta',
        'Karyawan BUMN',
        'Pegawai Negeri Sipil (ASN)',
        'Wirausaha',
        'Tenaga Kesehatan',
        'Tenaga Pengajar',
        'TNI',
        'Polisi',
        'Security/ Satpam',
        'Pelajar/ Mahasiswa',
        'Ibu Rumah Tangga',
        'Petani',
        'Peternak',
        'Nelayan',
        'Transportasi',
        'Buruh Harian Lepas',
        'Seniman',
        'Tokoh Agama',
        'Belum/ Tidak Bekerja',
        'Pensiunan',
        'Lainnya'
    ],

    'kasir_shift'=>[
        ['nama_shift'=>'shift 1','waktu_mulai'=>'07:01','waktu_selesai'=>'14:00'],
        ['nama_shift'=>'shift 2','waktu_mulai'=>'14:01','waktu_selesai'=>'21:00'],
        ['nama_shift'=>'shift 3','waktu_mulai'=>'21:01','waktu_selesai'=>'07:00']
    ],

    'suku_bangsa' => [
        'Melayu',
        'Jawa',
        'Sunda',
        'Batak',
        'Betawi',
        'Bugis',
        'Lainnya'
    ],
];
