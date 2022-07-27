<?php

namespace App\Imports;

use App\Models\Pasien;
use App\Models\Pendaftaran;
use Exception;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;

class PendaftaranImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if ($row[1] != "Jenis Identitas") {
            $checkPasien = Pasien::where('nomor_ktp', $row['2'])->first();
            if ($checkPasien) {
                $pasien = Pasien::where('id', $checkPasien->id)->update([
                    'nama' => $row[0],
                    'jenis_identitas' => $row[1],
                    'nomor_ktp' => $row[2],
                    'nomor_rekam_medis' => generateKodeRekamMedis(),
                    'tempat_lahir' => $row[3],
                    'tanggal_lahir' => $row[4],
                    'alamat' => $row[6],
                    'rt_rw' => $row[7],
                    'nomor_hp' => $row[8],
                    'penanggung_jawab' => $row[10],
                    'nomor_hp_penanggung_jawab' => $row[11],
                    'alamat_penanggung_jawab' => $row[12],
                ]);
            } else {
                $pasien = Pasien::create([
                    'nama' => $row[0],
                    'jenis_identitas' => $row[1],
                    'nomor_ktp' => $row[2],
                    'nomor_rekam_medis' => generateKodeRekamMedis(),
                    'tempat_lahir' => $row[3],
                    'tanggal_lahir' => $row[4],
                    'alamat' => $row[6],
                    'rt_rw' => $row[7],
                    'nomor_hp' => $row[8],
                    'penanggung_jawab' => $row[10],
                    'nomor_hp_penanggung_jawab' => $row[11],
                    'alamat_penanggung_jawab' => $row[12],
                ]);
            }

            $pendaftaran = Pendaftaran::create([
                'kode' => generateKodePendaftaran(),
                'pasien_id' => $checkPasien->id,
                'poliklinik_id' => 2,
                'penanggung_jawab' => $checkPasien->penanggung_jawab,
                'alamat_penanggung_jawab' => $checkPasien->alamat_penanggung_jawab,
                'no_hp_penanggung_jawab' => $checkPasien->nomor_hp_penanggung_jawab,
                'jenis_identitas' => $checkPasien->jenis_identitas
            ]);

            // Send message
            $message = "Terima kasih $row[0], pendaftaran online anda sudah kami proses dan nomor pendaftaran anda adalah $pendaftaran->kode, silahkan datang pada jam yang sudah ditentukan.";
            $phone = $row[8];
            $messageType = 'text';
            $device = 'redmi-9c';
            $sendMessage = message('POST', $message, $phone, $messageType, $device);
        }
    }
}
