<?php

namespace Database\Seeders;

use App\Models\UnitKerja;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitKerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $unitKerja = [
            "PUPR",
            "Sub Bagian Keuangan, Perlengkapan, dan Pengelolaan Barang Milik Daerah",
            "Subbagian Kepegawaian dan Umum",
            "Bidang Sumber Daya Air",
            "Bidang Bina Marga",
            "Bidang Cipta Karya",
            "Bidang Perumahan & Kawasan Permukiman",
            "Bidang Pertanahan & Penataan Ruang",
            "Bidang Bina Jasa Konstruksi",
            "Seksi Sungai, Danau, dan Pantai",
            "Seksi Irigasi dan Rawa",
            "Seksi Pembangunan Jalan dan Jembatan",
            "Seksi Preservasi Jalan dan Jembatan",
            "Seksi Penataan Bangunan dan Lingkungan",
            "Seksi Air Minum & Penyehatan Lingkungan",
            "Seksi Pertanahan",
            "Seksi Penataan Ruang",
            "Seksi Pengaturan Jasa Konstruksi",
            "Seksi Pemberdayaan & Pengawasan Jasa Konstruksi",
        ];

        foreach ($unitKerja as $nama) {
            UnitKerja::create(["nama" => $nama]);
        }
    }
}
