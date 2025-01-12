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
        Schema::create('tembusan_surats', function (Blueprint $table) {
            $table->id();
            $table->enum("jenis_surat", ["umum", "surat_cuti"])->default("umum");
            $table->bigInteger("surat_id");
            $table->bigInteger("user_tembusan_id");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tembusan_surats');
    }
};
