<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use PDO;

class TembusanSurat extends Model
{
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, "user_tembusan_id", "id");
    }
}
