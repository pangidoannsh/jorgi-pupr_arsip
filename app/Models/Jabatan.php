<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $table = 'jabatans';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->hasOne(User::class, "id", "user_id");
    }
}
