<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
    Schema::create('laporan_dukungans', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        // Pastikan nama tabel laporans kamu benar (biasanya 'laporans' atau 'pengaduans')
        // Sesuaikan 'id_laporan' dengan nama kolom primary key di tabel laporan kamu
        $table->unsignedBigInteger('id_laporan'); 
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_dukungans');
    }
};
