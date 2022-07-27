<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hasil Pemeriksaan Ondotogram</title>
    <style>
        .text-center {
            text-align: center;
        } 
        .mt-3 {
            margin-top: 30px;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
            border: 1px solid black;
        }
        
        table.table th{
            border: 1px solid black;
        }

        table.table td{
            border: 1px solid black;
        }

        .image {
            opacity: 0.5; 
        }
        .image-selected {
            opacity: 1;
        }

    </style>
</head>
<body style="padding:10px">

    <h3 class="text-center">FORMULIR PEMERIKSAAN ODONTOGRAM</h3>

    <div class="mt-3">

        <div style="">
            <table>
                <tr align="left">
                    <td>Nama Lengkap</td>
                    <td>:</td>
                    <th>{{ $pendaftaran[0]->pendaftaran->pasien->nama }}</th>
                    <td width="180">&nbsp;</td>
                    <td>Jenis Kelamin</td>
                    <td>:</td>
                    <th>{{ $pendaftaran[0]->pendaftaran->pasien->jenis_kelamin }}</th>
                </tr>
                <tr align="left">
                    <td>NIK/No.KTP</td>
                    <td>:</td>
                    <th>{{ $pendaftaran[0]->pendaftaran->pasien->nomor_ktp }}</th>
                    <td></td>
                    <td>Umur</td>
                    <td>:</td>
                    <th>{{ $nomorAntrian->pendaftaran->pasien->umur }} Tahun</th>
                </tr>
            </table>
        </div>

        <div style="margin-top: 50px">
            <table class="table">
                <thead>
                    <tr>
                        <th width="30">No</th>
                        <th>Gigi</th>
                        <th>Kondisi</th>
                        <th>Anamnesa</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendaftaran as $p)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $p->kode_gigi }}</td>
                        <td>{{ $p->tbm->indonesia??'-' }}</td>
                        <td>{{ $p->anamnesa }}</td>
                        <td>{{ $p->tindakan->tindakan }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
            
        <div style="margin-left: -20rem;">
          <table id="Table_01" height="680" style="transform:scale(.5);margin-top: -10rem;" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td>
                  <img data-kode="18" class="{{ checkDataGigi(18, $pendaftaran[0]->pendaftaran_id) == true ? 'image-selected' : 'image' }}" src="{{ public_path('images') }}/141686611-90067e00-8288-4e3d-842e-392adb7c9080_01.gif" width="151" height="181" alt=""></td>
                <td>
                  <img data-kode="17" class="{{ checkDataGigi(17, $pendaftaran[0]->pendaftaran_id) == true ? 'image-selected' : 'image' }}" src="{{ public_path('images') }}/141686611-90067e00-8288-4e3d-842e-392adb7c9080_02.gif" width="72" height="181" alt=""></td>
                <td>
                  <img data-kode="16" class="{{ checkDataGigi(16, $pendaftaran[0]->pendaftaran_id) == true ? 'image-selected' : 'image' }}" src="{{ public_path('images') }}/141686611-90067e00-8288-4e3d-842e-392adb7c9080_03.gif" width="74" height="181" alt=""></td>
                <td>
                  <img data-kode="15" class="{{ checkDataGigi(15, $pendaftaran[0]->pendaftaran_id) == true ? 'image-selected' : 'image' }}" src="{{ public_path('images') }}/141686611-90067e00-8288-4e3d-842e-392adb7c9080_04.gif" width="73" height="181" alt=""></td>
                <td>
                  <img data-kode="14" class="{{ checkDataGigi(14, $pendaftaran[0]->pendaftaran_id) == true ? 'image-selected' : 'image' }}" src="{{ public_path('images') }}/141686611-90067e00-8288-4e3d-842e-392adb7c9080_05.gif" width="72" height="181" alt=""></td>
                <td>
                  <img data-kode="13" class="{{ checkDataGigi(13, $pendaftaran[0]->pendaftaran_id) == true ? 'image-selected' : 'image' }}" src="{{ public_path('images') }}/141686611-90067e00-8288-4e3d-842e-392adb7c9080_06.gif" width="74" height="181" alt=""></td>
                <td>
                  <img data-kode="12" class="{{ checkDataGigi(12, $pendaftaran[0]->pendaftaran_id) == true ? 'image-selected' : 'image' }}" src="{{ public_path('images') }}/141686611-90067e00-8288-4e3d-842e-392adb7c9080_07.gif" width="75" height="181" alt=""></td>
                <td>
                  <img data-kode="11" class="{{ checkDataGigi(11, $pendaftaran[0]->pendaftaran_id) == true ? 'image-selected' : 'image' }}" src="{{ public_path('images') }}/141686611-90067e00-8288-4e3d-842e-392adb7c9080_08.gif" width="72" height="181" alt=""></td>
                <td>
                  <img data-kode="21" class="{{ checkDataGigi(21, $pendaftaran[0]->pendaftaran_id) == true ? 'image-selected' : 'image' }}" src="{{ public_path('images') }}/141686611-90067e00-8288-4e3d-842e-392adb7c9080_09.gif" width="74" height="181" alt=""></td>
                <td>
                  <img data-kode="22" class="{{ checkDataGigi(22, $pendaftaran[0]->pendaftaran_id) == true ? 'image-selected' : 'image' }}" src="{{ public_path('images') }}/141686611-90067e00-8288-4e3d-842e-392adb7c9080_10.gif" width="71" height="181" alt=""></td>
                <td>
                  <img data-kode="23" class="{{ checkDataGigi(23, $pendaftaran[0]->pendaftaran_id) == true ? 'image-selected' : 'image' }}" src="{{ public_path('images') }}/141686611-90067e00-8288-4e3d-842e-392adb7c9080_11.gif" width="76" height="181" alt=""></td>
                <td>
                  <img data-kode="24" class="{{ checkDataGigi(24, $pendaftaran[0]->pendaftaran_id) == true ? 'image-selected' : 'image' }}" src="{{ public_path('images') }}/141686611-90067e00-8288-4e3d-842e-392adb7c9080_12.gif" width="71" height="181" alt=""></td>
                <td>
                  <img data-kode="25" class="{{ checkDataGigi(25, $pendaftaran[0]->pendaftaran_id) == true ? 'image-selected' : 'image' }}" src="{{ public_path('images') }}/141686611-90067e00-8288-4e3d-842e-392adb7c9080_13.gif" width="78" height="181" alt=""></td>
                <td>
                  <img data-kode="26" class="{{ checkDataGigi(26, $pendaftaran[0]->pendaftaran_id) == true ? 'image-selected' : 'image' }}" src="{{ public_path('images') }}/141686611-90067e00-8288-4e3d-842e-392adb7c9080_14.gif" width="69" height="181" alt=""></td>
                <td>
                  <img data-kode="27" class="{{ checkDataGigi(27, $pendaftaran[0]->pendaftaran_id) == true ? 'image-selected' : 'image' }}" src="{{ public_path('images') }}/141686611-90067e00-8288-4e3d-842e-392adb7c9080_15.gif" width="76" height="181" alt=""></td>
                <td>
                  <img data-kode="28" class="{{ checkDataGigi(28, $pendaftaran[0]->pendaftaran_id) == true ? 'image-selected' : 'image' }}" src="{{ public_path('images') }}/141686611-90067e00-8288-4e3d-842e-392adb7c9080_16.gif" width="162" height="181" alt=""></td>
              </tr>
              <tr>
                <td colspan="4">
                  <img data-kode="55" class="{{ checkDataGigi(55, $pendaftaran[0]->pendaftaran_id) == true ? 'image-selected' : 'image' }}" src="{{ public_path('images') }}/141686611-90067e00-8288-4e3d-842e-392adb7c9080_17.gif" width="370" height="166" alt=""></td>
                <td>
                  <img data-kode="54" class="{{ checkDataGigi(54, $pendaftaran[0]->pendaftaran_id) == true ? 'image-selected' : 'image' }}" src="{{ public_path('images') }}/141686611-90067e00-8288-4e3d-842e-392adb7c9080_18.gif" width="72" height="166" alt=""></td>
                <td>
                  <img data-kode="53" class="{{ checkDataGigi(53, $pendaftaran[0]->pendaftaran_id) == true ? 'image-selected' : 'image' }}" src="{{ public_path('images') }}/141686611-90067e00-8288-4e3d-842e-392adb7c9080_19.gif" width="74" height="166" alt=""></td>
                <td>
                  <img data-kode="52" class="{{ checkDataGigi(52, $pendaftaran[0]->pendaftaran_id) == true ? 'image-selected' : 'image' }}" src="{{ public_path('images') }}/141686611-90067e00-8288-4e3d-842e-392adb7c9080_20.gif" width="75" height="166" alt=""></td>
                <td>
                  <img data-kode="51" class="{{ checkDataGigi(51, $pendaftaran[0]->pendaftaran_id) == true ? 'image-selected' : 'image' }}" src="{{ public_path('images') }}/141686611-90067e00-8288-4e3d-842e-392adb7c9080_21.gif" width="72" height="166" alt=""></td>
                <td>
                  <img data-kode="61" class="{{ checkDataGigi(61, $pendaftaran[0]->pendaftaran_id) == true ? 'image-selected' : 'image' }}" src="{{ public_path('images') }}/141686611-90067e00-8288-4e3d-842e-392adb7c9080_22.gif" width="74" height="166" alt=""></td>
                <td>
                  <img data-kode="62" class="{{ checkDataGigi(62, $pendaftaran[0]->pendaftaran_id) == true ? 'image-selected' : 'image' }}" src="{{ public_path('images') }}/141686611-90067e00-8288-4e3d-842e-392adb7c9080_23.gif" width="71" height="166" alt=""></td>
                <td>
                  <img data-kode="63" class="{{ checkDataGigi(63, $pendaftaran[0]->pendaftaran_id) == true ? 'image-selected' : 'image' }}" src="{{ public_path('images') }}/141686611-90067e00-8288-4e3d-842e-392adb7c9080_24.gif" width="76" height="166" alt=""></td>
                <td>
                  <img data-kode="64" class="{{ checkDataGigi(64, $pendaftaran[0]->pendaftaran_id) == true ? 'image-selected' : 'image' }}" src="{{ public_path('images') }}/141686611-90067e00-8288-4e3d-842e-392adb7c9080_25.gif" width="71" height="166" alt=""></td>
                <td colspan="4">
                  <img data-kode="65" class="{{ checkDataGigi(65, $pendaftaran[0]->pendaftaran_id) == true ? 'image-selected' : 'image' }}" src="{{ public_path('images') }}/141686611-90067e00-8288-4e3d-842e-392adb7c9080_26.gif" width="385" height="166" alt=""></td>
              </tr>
              <tr>
                <td colspan="4">
                  <img data-kode="85" class="{{ checkDataGigi(85, $pendaftaran[0]->pendaftaran_id) == true ? 'image-selected' : 'image' }}" src="{{ public_path('images') }}/141686611-90067e00-8288-4e3d-842e-392adb7c9080_27.gif" width="370" height="155" alt=""></td>
                <td>
                  <img data-kode="84" class="{{ checkDataGigi(84, $pendaftaran[0]->pendaftaran_id) == true ? 'image-selected' : 'image' }}" src="{{ public_path('images') }}/141686611-90067e00-8288-4e3d-842e-392adb7c9080_28.gif" width="72" height="155" alt=""></td>
                <td>
                  <img data-kode="83" class="{{ checkDataGigi(83, $pendaftaran[0]->pendaftaran_id) == true ? 'image-selected' : 'image' }}" src="{{ public_path('images') }}/141686611-90067e00-8288-4e3d-842e-392adb7c9080_29.gif" width="74" height="155" alt=""></td>
                <td>
                  <img data-kode="82" class="{{ checkDataGigi(82, $pendaftaran[0]->pendaftaran_id) == true ? 'image-selected' : 'image' }}" src="{{ public_path('images') }}/141686611-90067e00-8288-4e3d-842e-392adb7c9080_30.gif" width="75" height="155" alt=""></td>
                <td>
                  <img data-kode="81" class="{{ checkDataGigi(81, $pendaftaran[0]->pendaftaran_id) == true ? 'image-selected' : 'image' }}" src="{{ public_path('images') }}/141686611-90067e00-8288-4e3d-842e-392adb7c9080_31.gif" width="72" height="155" alt=""></td>
                <td>
                  <img data-kode="71" class="{{ checkDataGigi(71, $pendaftaran[0]->pendaftaran_id) == true ? 'image-selected' : 'image' }}" src="{{ public_path('images') }}/141686611-90067e00-8288-4e3d-842e-392adb7c9080_32.gif" width="74" height="155" alt=""></td>
                <td>
                  <img data-kode="72" class="{{ checkDataGigi(72, $pendaftaran[0]->pendaftaran_id) == true ? 'image-selected' : 'image' }}" src="{{ public_path('images') }}/141686611-90067e00-8288-4e3d-842e-392adb7c9080_33.gif" width="71" height="155" alt=""></td>
                <td>
                  <img data-kode="73" class="{{ checkDataGigi(73, $pendaftaran[0]->pendaftaran_id) == true ? 'image-selected' : 'image' }}" src="{{ public_path('images') }}/141686611-90067e00-8288-4e3d-842e-392adb7c9080_34.gif" width="76" height="155" alt=""></td>
                <td>
                  <img data-kode="74" class="{{ checkDataGigi(74, $pendaftaran[0]->pendaftaran_id) == true ? 'image-selected' : 'image' }}" src="{{ public_path('images') }}/141686611-90067e00-8288-4e3d-842e-392adb7c9080_35.gif" width="71" height="155" alt=""></td>
                <td colspan="4">
                  <img data-kode="75" class="{{ checkDataGigi(75, $pendaftaran[0]->pendaftaran_id) == true ? 'image-selected' : 'image' }}" src="{{ public_path('images') }}/141686611-90067e00-8288-4e3d-842e-392adb7c9080_36.gif" width="385" height="155" alt=""></td>
              </tr>
              <tr>
                <td>
                  <img data-kode="48" class="{{ checkDataGigi(48, $pendaftaran[0]->pendaftaran_id) == true ? 'image-selected' : 'image' }}" src="{{ public_path('images') }}/141686611-90067e00-8288-4e3d-842e-392adb7c9080_37.gif" width="151" height="178" alt=""></td>
                <td>
                  <img data-kode="47" class="{{ checkDataGigi(47, $pendaftaran[0]->pendaftaran_id) == true ? 'image-selected' : 'image' }}" src="{{ public_path('images') }}/141686611-90067e00-8288-4e3d-842e-392adb7c9080_38.gif" width="72" height="178" alt=""></td>
                <td>
                  <img data-kode="46" class="{{ checkDataGigi(46, $pendaftaran[0]->pendaftaran_id) == true ? 'image-selected' : 'image' }}" src="{{ public_path('images') }}/141686611-90067e00-8288-4e3d-842e-392adb7c9080_39.gif" width="74" height="178" alt=""></td>
                <td>
                  <img data-kode="45" class="{{ checkDataGigi(45, $pendaftaran[0]->pendaftaran_id) == true ? 'image-selected' : 'image' }}" src="{{ public_path('images') }}/141686611-90067e00-8288-4e3d-842e-392adb7c9080_40.gif" width="73" height="178" alt=""></td>
                <td>
                  <img data-kode="44" class="{{ checkDataGigi(44, $pendaftaran[0]->pendaftaran_id) == true ? 'image-selected' : 'image' }}" src="{{ public_path('images') }}/141686611-90067e00-8288-4e3d-842e-392adb7c9080_41.gif" width="72" height="178" alt=""></td>
                <td>
                  <img data-kode="43" class="{{ checkDataGigi(43, $pendaftaran[0]->pendaftaran_id) == true ? 'image-selected' : 'image' }}" src="{{ public_path('images') }}/141686611-90067e00-8288-4e3d-842e-392adb7c9080_42.gif" width="74" height="178" alt=""></td>
                <td>
                  <img data-kode="42" class="{{ checkDataGigi(42, $pendaftaran[0]->pendaftaran_id) == true ? 'image-selected' : 'image' }}" src="{{ public_path('images') }}/141686611-90067e00-8288-4e3d-842e-392adb7c9080_43.gif" width="75" height="178" alt=""></td>
                <td>
                  <img data-kode="41" class="{{ checkDataGigi(41, $pendaftaran[0]->pendaftaran_id) == true ? 'image-selected' : 'image' }}" src="{{ public_path('images') }}/141686611-90067e00-8288-4e3d-842e-392adb7c9080_44.gif" width="72" height="178" alt=""></td>
                <td>
                  <img data-kode="31" class="{{ checkDataGigi(31, $pendaftaran[0]->pendaftaran_id) == true ? 'image-selected' : 'image' }}" src="{{ public_path('images') }}/141686611-90067e00-8288-4e3d-842e-392adb7c9080_45.gif" width="74" height="178" alt=""></td>
                <td>
                  <img data-kode="32" class="{{ checkDataGigi(32, $pendaftaran[0]->pendaftaran_id) == true ? 'image-selected' : 'image' }}" src="{{ public_path('images') }}/141686611-90067e00-8288-4e3d-842e-392adb7c9080_46.gif" width="71" height="178" alt=""></td>
                <td>
                  <img data-kode="33" class="{{ checkDataGigi(33, $pendaftaran[0]->pendaftaran_id) == true ? 'image-selected' : 'image' }}" src="{{ public_path('images') }}/141686611-90067e00-8288-4e3d-842e-392adb7c9080_47.gif" width="76" height="178" alt=""></td>
                <td>
                  <img data-kode="34" class="{{ checkDataGigi(34, $pendaftaran[0]->pendaftaran_id) == true ? 'image-selected' : 'image' }}" src="{{ public_path('images') }}/141686611-90067e00-8288-4e3d-842e-392adb7c9080_48.gif" width="71" height="178" alt=""></td>
                <td>
                  <img data-kode="35" class="{{ checkDataGigi(35, $pendaftaran[0]->pendaftaran_id) == true ? 'image-selected' : 'image' }}" src="{{ public_path('images') }}/141686611-90067e00-8288-4e3d-842e-392adb7c9080_49.gif" width="78" height="178" alt=""></td>
                <td>
                  <img data-kode="36" class="{{ checkDataGigi(36, $pendaftaran[0]->pendaftaran_id) == true ? 'image-selected' : 'image' }}" src="{{ public_path('images') }}/141686611-90067e00-8288-4e3d-842e-392adb7c9080_50.gif" width="69" height="178" alt=""></td>
                <td>
                  <img data-kode="37" class="{{ checkDataGigi(37, $pendaftaran[0]->pendaftaran_id) == true ? 'image-selected' : 'image' }}" src="{{ public_path('images') }}/141686611-90067e00-8288-4e3d-842e-392adb7c9080_51.gif" width="76" height="178" alt=""></td>
                <td>
                  <img data-kode="38" class="{{ checkDataGigi(38, $pendaftaran[0]->pendaftaran_id) == true ? 'image-selected' : 'image' }}" src="{{ public_path('images') }}/141686611-90067e00-8288-4e3d-842e-392adb7c9080_52.gif" width="162" height="178" alt=""></td>
              </tr>
          </table>
        </div>

        <div>
            <table style="margin-top: -9rem">
                <tr align="left">
                    <td>Occlusi</td>
                    <td>:</td>
                    <td>-</td>
                </tr>
                <tr align="left">
                    <td>Torus Palatinus</td>
                    <td>:</td>
                    <td>-</td>
                </tr>
                <tr align="left">
                    <td>Torus Mandibularis</td>
                    <td>:</td>
                    <td>-</td>
                </tr>
                <tr align="left">
                    <td>Palatum</td>
                    <td>:</td>
                    <td>-</td>
                </tr>
                <tr align="left">
                    <td>Diastema</td>
                    <td>:</td>
                    <td>-</td>
                </tr>
                <tr align="left">
                    <td>Gigi Anomali</td>
                    <td>:</td>
                    <td>-</td>
                </tr>
                <tr align="left">
                    <td>Lain - lain</td>
                    <td>:</td>
                    <td>-</td>
                </tr>
                <tr align="left">
                    <td>D : ___ M : ___ F : ___</td>
                </tr>
            </table>
            <table style="margin-top: 10px">
                <tr align="left">
                    <td width="300">Jumlah photo yang diambil _____ (digital/intraoral)*</td>
                </tr>
                <tr align="left">
                    <td width="300">Jumlah rontgen photo yang diambil _____ (Dental/PA/OPG/Ceph)*</td>
                </tr>
            </table>

            <table style="margin-top: 15px;border:1px solid black" width="100%">
                <thead>
                    <tr>
                        <th>Diperiksa Oleh</th>
                        <th>Tanggal Pemeriksaan</th>
                        <th>Tanda Tangan Pemeriksa</th>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr align="center">
                        <td>{{ Auth::user()->name }}</td>
                        <td>{{ now() }}</td>
                    </tr>
                </thead>
            </table>
        </div>
        
    </div>
    
</body>
</html>