<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporans', function (Blueprint $table) {
            $table->id('id_laporan'); // Primary Key
            $table->char('nik_pelapor', 16); // Foreign Key ke Users.nik
            $table->text('isi_laporan'); // Detail aduan
            $table->string('lokasi'); // Lokasi kejadian
            $table->string('foto_bukti'); // Nama file foto
            $table->string('kategori')->nullable(); // Untuk Smart Dispatch
            $table->enum('prioritas', ['rendah', 'sedang', 'tinggi'])->nullable(); // Untuk SLA
            $table->enum('status_laporan', ['0', 'proses', 'selesai'])->default('0'); // Status penanganan
            $table->string('qr_code_path')->nullable(); // Untuk QR Tracking
            $table->integer('jumlah_upvote')->default(0); // Untuk Priority Task
            $table->timestamps();

            // Relasi ke tabel users melalui kolom NIK
            $table->foreign('nik_pelapor')->references('nik')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};