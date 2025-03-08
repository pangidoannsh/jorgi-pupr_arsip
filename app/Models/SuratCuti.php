<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratCuti extends Model
{
    protected $guarded = ['id'];

    public function getJenisUsulanAttribute()
    {
        return "Surat Cuti";
    }


    public function pengaju()
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }

    public function ditujukan()
    {
        return $this->belongsTo(Jabatan::class, "diajukan_kepada", "id");
    }

    public function tembusan()
    {
        return $this->hasMany(TembusanSurat::class, "surat_id", "id");
    }

    public function getLamaCutiAttribute()
    {
        return \Carbon\CarbonPeriod::create($this->tanggal_mulai, $this->tanggal_selesai)->count();
    }
}
