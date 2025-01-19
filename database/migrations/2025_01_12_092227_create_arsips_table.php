<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('arsips', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("user_created");
            $table->string("kode_klasifikasi");
            $table->string("nomor_berkas");
            $table->string("nomor_arsip");
            $table->string("uraian_informasi");
            $table->string("file")->nullable();
            $table->string("url_file")->nullable();
            $table->integer("jumlah");
            $table->string("tingkat_perkembangan");
            $table->string("keterangan_nomor_box");
            $table->date("tanggal_mulai");
            $table->date("tanggal_selesai");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arsips');
    }
};
