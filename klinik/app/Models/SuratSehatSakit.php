<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class SuratSehatSakit extends Model
{
    protected $table = 'surat_sehat_sakit';
    protected $guarded = ['id'];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
