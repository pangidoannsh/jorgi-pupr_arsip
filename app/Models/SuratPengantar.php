<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratPengantar extends Model
{
    protected $guarded = ['id'];

    public function getJenisUsulanAttribute()
    {
        return "Surat Pengantar";
    }

    public function pengaju()
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }

    public function ditujukan()
    {
        return $this->belongsTo(Jabatan::class, "diajukan_kepada", "id");
    }
}
