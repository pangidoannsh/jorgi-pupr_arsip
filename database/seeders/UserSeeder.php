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
            "unit_id" => "1",
            "name" => "admin",
            "role" => "admin",
            "password" => bcrypt("1")
        ]);

        User::create([
            "nip" => "ux123",
            "unit_id" => "1",
            "name" => "Qosim",
            "role" => "user",
            "password" => bcrypt("1")
        ]);
    }
}
