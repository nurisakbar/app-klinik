<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Antrian extends Model
{
    protected $table = "antrian";

    protected $fillable = ['pendaftaran_id','nomor_antrian','status'];

    public function pendaftaran()
    {
        return $this->belongsTo('App\Models\Pendaftaran');
    }

    public static function detailAntrian()
    {
        $query = "SELECT 
            count(nomor_antrian) as 'jumlah_antrian',
            (SELECT nomor_antrian FROM antrian ORDER BY updated_at DESC LIMIT 1) AS 'antrian_sekarang',
            (SELECT nomor_antrian FROM antrian WHERE antrian.status = 0 ORDER BY nomor_antrian ASC LIMIT 1) AS 'antrian_selanjutnya',
            (SELECT count(nomor_antrian) FROM antrian WHERE antrian.status = 0) AS 'sisa_antrian'
            FROM antrian LIMIT 1
            ";

        return DB::select($query);
    }
}
