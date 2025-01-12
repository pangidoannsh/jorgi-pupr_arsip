<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use PDO;

class TembusanSurat extends Model
{
    protected $table = 'tembusan_surat';
    protected $guarded = ['id'];
}
