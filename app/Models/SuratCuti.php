<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratCuti extends Model
{
    protected $table = 'surat_cuti';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
