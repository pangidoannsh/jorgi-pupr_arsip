<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            "nip" => "admin123",
            "jabatan" => "KEPALA SUB BAGIAN UMUM",
            "unit_id" => "3",
            "name" => "admin",
            "role" => "admin",
            "ttd" => "uploads/user/ttd_dummy.png",
            "password" => bcrypt("1")
        ]);

        User::create([
            "nip" => "ux123",
            "jabatan" => "Jabatan ABC",
            "unit_id" => "5",
            "name" => "Qosim",
            "role" => "user",
            "ttd" => "uploads/user/ttd_dummy.png",
            "password" => bcrypt("1")
        ]);
        User::create([
            "nip" => "dp123",
            "jabatan" => "Jabatan XYZ",
            "unit_id" => "6",
            "name" => "Dewangga",
            "role" => "user",
            "ttd" => "uploads/user/ttd_dummy.png",
            "password" => bcrypt("1")
        ]);

        User::create([
            "nip" => "kepaladinas123",
            "jabatan" => "Kepala Dinas",
            "unit_id" => "1",
            "name" => "Burhanudin",
            "role" => "kepala_dinas",
            "ttd" => "uploads/user/ttd_dummy.png",
            "password" => bcrypt("1")
        ]);

        $users = [
            ["1976543210", "Sekretaris", 1, "Siti Aminah"],
            ["1965432109", "Kepala Sub Bagian Keuangan, Perlengkapan, dan Pengelolaan Barang Milik Daerah", 2, "Joko Santoso"],
            ["1943210987", "Kepala Bidang Sumber Daya Air", 4, "Budi Prasetyo"],
            ["1932109876", "Kepala Seksi Sungai, Danau, dan Pantai", 10, "Rina Kartika"],
            ["1921098765", "Kepala Seksi Irigasi dan Rawa", 11, "Arif Hidayat"],
            ["1910987654", "Kepala Bidang Bina Marga", 5, "Samsul Bahri"],
            ["1909876543", "Kepala Seksi Pembangunan Jalan dan Jembatan", 12, "Eka Firmansyah"],
            ["1898765432", "Kepala Seksi Preservasi Jalan dan Jembatan", 13, "Lestari Ananda"],
            ["1887654321", "Kepala Bidang Cipta Karya", 6, "Hendra Wijaya"],
            ["1876543210", "Kepala Seksi Penataan Bangunan dan Lingkungan", 14, "Nurul Aini"],
            ["1865432109", "Kepala Seksi Air Minum & Penyehatan Lingkungan", 15, "Agus Saputra"],
            ["1854321098", "Kepala Bidang Perumahan & Kawasan Permukiman", 7, "Siti Rahayu"],
            ["1843210987", "Kepala Bidang Pertanahan & Penataan Ruang", 8, "Dedi Pratama"],
            ["1832109876", "Kepala Seksi Pertanahan", 16, "Yulia Kurnia"],
            ["1821098765", "Kepala Seksi Penataan Ruang", 17, "Adi Wibowo"],
            ["1810987654", "Kepala Bidang Bina Jasa Konstruksi", 9, "Rizky Fauzan"],
            ["1809876543", "Kepala Seksi Pengaturan Jasa Konstruksi", 18, "Rahma Dewi"],
            ["1798765432", "Kepala Seksi Pemberdayaan & Pengawasan Jasa Konstruksi", 19, "Fauzan Hakim"],
        ];

        foreach ($users as $user) {
            User::create([
                "nip" => $user[0],
                "jabatan" => $user[1],
                "unit_id" => $user[2],
                "name" => $user[3],
                "role" => "user",
                "ttd" => "uploads/user/ttd_dummy.png",
                "password" => bcrypt("123456"),
            ]);
        }
    }
}
