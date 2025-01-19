<?php

namespace Database\Seeders;

use App\Models\Klasifikasi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KlasifikasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Klasifikasi::create([
            "kode_klasifikasi" => "A1234",
            "nama" => "Surat ABCD"
        ]);
        Klasifikasi::create([
            "kode_klasifikasi" => "B1234",
            "nama" => "Surat PX"
        ]);
    }
}
