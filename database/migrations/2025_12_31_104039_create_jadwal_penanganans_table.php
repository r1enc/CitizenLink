<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_penanganans', function (Blueprint $table) {
            $table->id('id_jadwal'); // PK
            $table->unsignedBigInteger('id_laporan'); // FK ke Laporan
            $table->unsignedBigInteger('id_petugas'); // FK ke User
            $table->dateTime('tgl_mulai'); // Jadwal mulai
            $table->dateTime('tgl_selesai'); // Deadline SLA
            $table->string('prioritas'); // Tingkat urgensi jadwal
            $table->timestamps();

            // Relasi 1:1 ke Laporan
            $table->foreign('id_laporan')->references('id_laporan')->on('laporans')->onDelete('cascade');
            // Relasi 1:N ke User (Petugas)
            $table->foreign('id_petugas')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_penanganans');
    }
};