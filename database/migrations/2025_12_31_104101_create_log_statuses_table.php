<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('log_statuses', function (Blueprint $table) {
            $table->id('id_log'); // PK
            $table->unsignedBigInteger('id_laporan'); // FK ke Laporan
            $table->string('keterangan_status'); // Riwayat progres
            $table->timestamp('timestamp')->useCurrent(); // Waktu perubahan
            $table->timestamps();

            // Relasi 1:N ke Laporan untuk fitur QR Tracking
            $table->foreign('id_laporan')->references('id_laporan')->on('laporans')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_statuses');
    }
};