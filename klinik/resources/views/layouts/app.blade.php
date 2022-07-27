<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="{{asset('adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/font-awesome/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/Ionicons/css/ionicons.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('adminlte/dist/css/AdminLTE.min.css')}}">
    <link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/dist/css/skins/_all-skins.min.css">
    @stack('css')
    <!-- Select 2 AdminLTE 2 Style -->
      <style>.select2-container--default .select2-selection--single,
      .select2-selection .select2-selection--single {
          border: 1px solid #d2d6de;
          border-radius: 0;
          padding: 6px 12px;
          height: 34px;
      }
  
      .select2-container .select2-selection--single .select2-selection__rendered {
          padding-right: 10px;
      }
  
      .select2-container .select2-selection--single .select2-selection__rendered {
          padding-left: 0;
      }
  
      .select2-container--default .select2-selection--single .select2-selection__arrow b {
          margin-top: 0;
      }
  
      .select2-container--default .select2-selection--single .select2-selection__arrow {
          height: 28px;
          right: 3px;
      }
      </style>


    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    
</head>

<body class="hold-transition skin-blue layout-top-nav">
    <div class="wrapper">
        <header class="main-header">
            <nav class="navbar navbar-static-top">
                <div class="containers">
                    <div class="navbar-header">
                        <a href="../../index2.html" class="navbar-brand"><b>SIKLINIK</b>pro</a>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#navbar-collapse">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>

                    <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                        <ul class="nav navbar-nav">
                            <?php
                            $administrator = [
                              ['icon' => 'fa fa-user', 'link' => '/home', 'label' => 'Dashboard'],
                              ['icon' => 'fa fa-bars', 'link' => '/home', 'label' => 'Data Master', 'submenu' => [
                                ['icon' => 'fa fa-clone', 'link' => '/satuan', 'label' => 'Data Satuan'],
                                ['icon' => 'fa fa-hospital-o', 'link' => '/poliklinik', 'label' => 'Data Poliklinik'],
                                ['icon' => 'fa fa-file-text', 'link' => '/diagnosa', 'label' => 'Data Diagnosa'],
                                ['icon' => 'fa fa-file-text', 'link' => '/tindakan', 'label' => 'Data Tindakan'],
                                // ['icon' => 'fa fa-file-text', 'link' => '/jenis-pemeriksaan-lab', 'label' => 'Jenis Pemeriksaan Lab'],
                                ['icon' => 'fa fa-list-ul', 'link' => '/gejala', 'label' => 'Data Gejala'],
                                ['icon' => 'fa fa-user-md', 'link' => '/user?jabatan=dokter', 'label' => 'Data Dokter'],
                                ['icon' => 'fa fa-cube', 'link' => '/supplier', 'label' => 'Data Supplier'],
                                ['icon' => 'fa fa-list-ul', 'link' => '/unit-stock', 'label' => 'Data Unit Stock'],
                                ['icon' => 'fa fa-user-md', 'link' => '/kategori', 'label' => 'Data Kategori'],
                                ['icon' => 'fa fa-user-md', 'link' => '/barang', 'label' => 'Data Barang'],
                                ['icon' => 'fa fa-user', 'link' => '/pbf', 'label' => 'Master PBF'],
                                ['icon' => 'fa fa-list-ul', 'link' => '/perusahaan-asuransi', 'label' => 'Perusahaan Asuransi'],
                                ['icon' => 'fa fa-list-ul', 'link' => '/icd', 'label' => 'Data ICD'],
                                // ['icon' => 'fa fa-home', 'link' => '/kamar', 'label' => 'Data Kamar'],
                                // ['icon' => 'fa fa-bed', 'link' => '/bed', 'label' => 'Data Bed'],
                              ]],
                              ['icon' => 'fa fa-bars', 'link' => '#', 'label' => 'Laporan', 'submenu' => [
                                ['icon' => 'fa fa-plus-square', 'link' => '/laporan/kunjungan-perpoli', 'label' => 'Kunjungan Perpoli'],
                                ['icon' => 'fa fa-plus-square', 'link' => '/laporan/perdiagnosa', 'label' => 'top 10 diagnosa'],
                                ['icon' => 'fa fa-plus-square', 'link' => '/stock-opname', 'label' => 'Stock Opname']
                              ]],
                      
                              //['icon' => 'fa fa-list-ul', 'link' => '/surat-sehat-sakit', 'label' => 'Data Surat Sehat Dan Sakit'],
                              ['icon' => 'fa fa-bars', 'link' => '/home', 'label' => 'Transaksi Apotek', 'submenu' => [
                                ['icon' => 'fa fa-cube', 'link' => '/purchase-order', 'label' => 'Purchase Order (PO)'],
                                ['icon' => 'fa fa-plus-square', 'link' => '/purchase-order/create', 'label' => 'Tambah Purchase Order (PO)'],
                                ['icon' => 'fa fa-cube', 'link' => '/permintaan-barang-internal', 'label' => 'Permintaan Barang Internal'],
                                ['icon' => 'fa fa-plus-square', 'link' => '/permintaan-barang-internal/create', 'label' => 'Buat Permintaan Barang'],
                              ]],
                              ['icon' => 'fa fa-user-circle-o', 'link' => '/user?jabatan=user', 'label' => 'Pengguna Aplikasi'],
                              ['icon' => 'fa fa-address-card', 'link' => '/pendaftaran', 'label' => 'Data Pasien Antri'],
                              ['icon' => 'fa fa-gear', 'link' => '/setting', 'label' => 'Setting Aplikasi']
                            ];
                      
                            $kasir = [
                              ['icon' => 'fa fa-user', 'link' => '/home', 'label' => 'Dashboard'],
                              ['icon' => 'fa fa-user-circle-o', 'link' => '/pendaftaran', 'label' => 'Data Pasien Antri'],
                              ['icon' => 'fa fa-user-circle-o', 'link' => '/laporan-transaksi', 'label' => 'Laporan Transaksi'],
                              ['icon' => 'fa fa-user-circle-o', 'link' => '/pengeluaran', 'label' => 'Pengeluaran'],
                              ['icon' => 'fa fa-list-ul', 'link' => '/surat', 'label' => 'Surat Surat'],
                            ];
                      
                            $apoteker = [
                              ['icon' => 'fa fa-user', 'link' => '/home', 'label' => 'Dashboard'],
                              ['icon' => 'fa fa-user-circle-o', 'link' => '/pendaftaran', 'label' => 'Data Pasien'],
                            ];
                      
                            $hrd = [
                              ['icon' => 'fa fa-user', 'link' => '/home', 'label' => 'Dashboard'],
                              ['icon' => 'fa fa-user-circle-o', 'link' => '/pegawai', 'label' => 'Data Pegawai'],
                              ['icon' => 'fa fa-list-alt', 'link' => '/shift', 'label' => 'Data Shift'],
                              ['icon' => 'fa fa-money', 'link' => '/gaji', 'label' => 'Laporan Gaji'],
                              ['icon' => 'fa fa-calendar-check-o', 'link' => '/harilibur', 'label' => 'Setting Hari Libur'],
                              ['icon' => 'fa fa-id-card', 'link' => '/kehadiran-pegawai', 'label' => 'Kehadiran Pegawai'],
                              ['icon' => 'fa fa-list-alt', 'link' => '/komponengaji', 'label' => 'Komponen Gaji'],
                              ['icon' => 'fa fa-list-alt', 'link' => '/kelompok-pegawai', 'label' => 'Kelompok Pegawai'],
                            ];
                      
                            $akutansi = [
                              ['icon' => 'fa fa-user', 'link' => '/home', 'label' => 'Dashboard'],
                              ['icon' => 'fa fa-bars', 'link' => '#', 'label' => 'Akutansi', 'submenu' => [
                                ['icon' => 'fa fa-user', 'link' => '/akun', 'label' => 'Akun'],
                                ['icon' => 'fa fa-user', 'link' => '/jurnal', 'label' => 'Jurnal Umum'],
                                ['icon' => 'fa fa-book', 'link' => '/buku-besar', 'label' => 'Buku Besar'],
                                ['icon' => 'fa fa-user', 'link' => '/neraca-saldo', 'label' => 'Neraca Saldo'],
                              ]],
                              ['icon' => 'fa fa-paste', 'link' => '/akun', 'label' => 'Laporan'],
                              ['icon' => 'fa fa-user', 'link' => '/purchase-order', 'label' => 'Purchase Order'],
                              ['icon' => 'fa fa-paste', 'link' => '/laporan-fee-tindakan', 'label' => 'Laporan Fee Tindakan'],
                              ['icon' => 'fa fa-user', 'link' => '/laporan-tagihan', 'label' => 'Laporan Tagihan'],
                              ['icon' => 'fa fa-paste', 'link' => '/laporan-barang-keluar', 'label' => 'Laporan Barang Keluar'],
                            ];
                      
                            $keuangan = [
                              ['icon' => 'fa fa-user', 'link' => '/home', 'label' => 'Dashboard'],
                              ['icon' => 'fa fa-user', 'link' => '/jurnal', 'label' => 'Jurnal Umum']
                            ];
                      
                            $bagian_gudang = [
                              ['icon' => 'fa fa-user', 'link' => '/home', 'label' => 'Dashboard'],
                              ['icon' => 'fa fa-user', 'link' => '/purchase-order', 'label' => 'Purchase Order'],
                              ['icon' => 'fa fa-user', 'link' => '/supplier', 'label' => 'Data Supplier'],
                              ['icon' => 'fa fa-book', 'link' => '/stock-opname', 'label' => 'Stock Opname'],
                              ['icon' => 'fa fa-user', 'link' => '/barang', 'label' => 'Master Barang'],
                              ['icon' => 'fa fa-user', 'link' => '/kategori', 'label' => 'Master Kategori'],
                              ['icon' => 'fa fa-clone', 'link' => '/satuan', 'label' => 'Data Satuan'],
                              ['icon' => 'fa fa-user', 'link' => '/pbf', 'label' => 'Master PBF']
                            ];
                      
                            $bagian_pendaftaran = [
                                ['icon' => 'fa fa-address-card', 'link' => '/pendaftaran', 'label' => 'Data Pasien Antri'],
                                ['icon' => 'fa fa-plus-square', 'link' => '/pasien/create', 'label' => 'pendaftaran Pasien Baru'],
                                ['icon' => 'fa fa-plus-square-o', 'link' => '/pendaftaran/create', 'label' => 'Pendaftaran Pasien Lama'],
                                ['icon' => 'fa fa-users', 'link' => '/pasien', 'label' => 'Database Pasien'],
                                ['icon' => 'fa fa-calendar', 'link' => '/laporan/kunjungan-perpoli', 'label' => 'Kunjungan Perpoli'],
                                ['icon' => 'fa fa-user-md', 'link' => '/user?jabatan=dokter', 'label' => 'Data Dokter'],
                                
                            ];
                      
                            $admin_medis = [
                              ['icon' => 'fa fa-television', 'link' => '/home', 'label' => 'Dashboard'],
                              ['icon' => 'fa fa-address-card', 'link' => '/pendaftaran', 'label' => 'daftar pasien antri'],
                              ['icon' => 'fa fa-address-card', 'link' => '/pasien', 'label' => 'Database Pasien'],
                            ];
                      
                            $rekamedis = [
                              ['icon' => 'fa fa-television', 'link' => '/home', 'label' => 'Dashboard'],
                              ['icon' => 'fa fa-address-card', 'link' => '/pasien', 'label' => 'Database Pasien'],
                              ['icon' => 'fa fa-address-card', 'link' => '/pendaftaran', 'label' => 'daftar pasien antri'],
                              ['icon' => 'fa fa-list-ul', 'link' => '/surat', 'label' => 'Surat Surat'],
                            ];
                            $pimpinan = [
                              ['icon' => 'fa fa-user', 'link' => '/home', 'label' => 'Dashboard'],
                              ['icon' => 'fa fa-user', 'link' => '/purchase-order', 'label' => 'Purchase Order'],
                              ['icon' => 'fa fa-money', 'link' => '/gaji', 'label' => 'Laporan Gaji'],
                            ];
                            $poliklinik = [
                              ['icon' => 'fa fa-book', 'link' => '/antrian', 'label' => 'Antrian'],
                              ['icon' => 'fa fa-list-ul', 'link' => '/surat', 'label' => 'Surat Surat'],
                              ['icon' => 'fa fa-list-ul', 'link' => '/stock', 'label' => 'Stock Barang & BHP'],
                              ['icon' => 'fa fa-address-card', 'link' => '/pendaftaran', 'label' => 'Data Pasien Antri']
                            ];
                      
                            $laboratorium = [
                              ['icon' => 'fa fa-address-card', 'link' => '/pendaftaran', 'label' => 'Data Pasien Antri'],
                              ['icon' => 'fa fa-file-text', 'link' => '/jenis-pemeriksaan-lab', 'label' => 'Jenis Pemeriksaan Lab'],
                            ];
                      
                            // pengaturan menu berdasarkan level
                            $menus = [
                              'administrator'   => $administrator,
                              'dokter'          => [],
                              'kasir'           => $kasir,
                              'keuangan'        => $keuangan,
                              'akutansi'        => $akutansi,
                              'hrd'             => $hrd,
                              'bagian_gudang'   => $bagian_gudang,
                              'admin_medis'     => $admin_medis,
                              'pimpinan'        => $pimpinan,
                              'apoteker'        => $apoteker,
                              'bagian_pendaftaran' => $bagian_pendaftaran,
                              'laboratorium'    => $laboratorium,
                              'rekamedis'       => $rekamedis,
                              'poliklinik'      => $poliklinik
                            ];
                            ?>

                            @foreach($menus[Auth::user()->role] as $menu)
                                @if(array_key_exists('submenu',$menu))

                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="{{$menu['icon']}}"></i>  {{strtoupper($menu['label'])}}<span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        @foreach ($menu['submenu'] as $submenu)
                                            <li><a href="{{$submenu['link']}}"><i class="{{$submenu['icon']}}"></i> {{ strtoupper($submenu['label'])}}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                                @else
                                    <li><a href="{{$menu['link']}}"><i class="{{$menu['icon']}}"></i> <span>{{strtoupper($menu['label'])}}</span></a></li>
                                @endif
                            @endforeach




                        </ul>
                    </div>


                    <?php $notifikasi = \DB::table('notifikasi')->where('user_id',session('user_id'))->whereRaw("left(created_at,10)='".date('Y-m-d')."'")->orderBy('created_at','desc') ?>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">

                            @include('layouts.notification')

                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                  <img src="{{asset('adminlte/dist/img/user2-160x160.jpg')}}" class="user-image" alt="User Image">
                                  <span class="hidden-xs">Hallo <b>{{ session('user_name')!=null?session('user_name') :Auth::user()->name}}</b></span>
                                </a>
                                <ul class="dropdown-menu">
                                  <!-- User image -->
                                  <li class="user-header">
                                    <img src="{{asset('adminlte/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
                        
                                    <p>
                                      {{ session('user_name')!=null?session('user_name') :Auth::user()->name}}
                                      <small>Member since Nov. 2012</small>
                                    </p>
                                  </li>
                                  <!-- Menu Body -->
                                  <li class="user-body">
                                    <div class="row">
                                      <div class="col-xs-4 text-center">
                                        <a href="#">Followers</a>
                                      </div>
                                      <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                      </div>
                                      <div class="col-xs-4 text-center">
                                        <a href="#">Friends</a>
                                      </div>
                                    </div>
                                    <!-- /.row -->
                                  </li>
                                  <!-- Menu Footer-->
                                  <li class="user-footer">
                                    <div class="pull-left">
                                      <a href="/profile" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                      {{-- <a href="#" class="btn btn-default btn-flat">Sign out</a> --}}
                                      <a class="btn btn-default btn-flat" href="{{ route('logout') }}"
                                                               onclick="event.preventDefault();
                                                                             document.getElementById('logout-form').submit();">
                                                                {{ __('Logout') }}
                                                            </a>
                                    </div>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                      @csrf
                                  </form>
                                  </li>
                                </ul>
                              </li>
                        </ul>
                    </div>

                </div>

            </nav>
        </header>

        <div class="content-wrapper">
            <div class="containers">
                @yield('content')
            </div>

        </div>

        <footer class="main-footer">
            <div class="container">
                <div class="pull-right hidden-xs">
                    <b>SIKLINIKPro Version</b> 1.0.0
                </div>
                <?php
                $setting = \DB::table('setting')->where('id',1)->first();
                ?>
                <strong>Copyright &copy; {{ date('Y')}} {{ $setting->nama_instansi}}  | Template By : <a href="https://adminlte.io">AdminLTE</a>.</strong> All rights
                reserved.
            </div>

        </footer>
    </div>


<!-- jQuery 3 -->
<!-- jQuery 3 -->
<script src="{{asset('adminlte/bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('adminlte/bower_components/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{asset('adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('adminlte/dist/js/adminlte.min.js')}}"></script>
@stack('scripts')
</body>

</html>
