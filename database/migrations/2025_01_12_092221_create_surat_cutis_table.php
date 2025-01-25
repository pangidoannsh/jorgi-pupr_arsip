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
        Schema::create('surat_cutis', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("user_created");
            $table->bigInteger("user_id");
            $table->string("jenis_cuti");
            $table->integer("lama_cuti");
            $table->date("tanggal_mulai");
            $table->string("alasan_cuti");
            $table->enum("status", ["menunggu", "ditolak", "disetujui_admin", "disetujui"])->default("menunggu");
            $table->string("lampiran")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_cutis');
    }
};
