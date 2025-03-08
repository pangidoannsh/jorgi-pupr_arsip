<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Arsip extends Model
{
    protected $table = 'arsips';
    protected $guarded = ['id'];

    public function getJenisUsulanAttribute()
    {
        return "Arsip";
    }

    public function klasifikasi()
    {
        return $this->belongsTo(Klasifikasi::class, "kode_klasifikasi", "kode_klasifikasi");
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
