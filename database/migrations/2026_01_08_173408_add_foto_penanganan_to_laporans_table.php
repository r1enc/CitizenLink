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
        Schema::table('laporans', function (Blueprint $table) {
            // Menambahkan kolom foto_penanganan setelah kolom foto_bukti
            // Dibuat nullable karena saat laporan baru dibuat, kolom ini pasti kosong (belum dikerjakan)
            $table->string('foto_penanganan')->nullable()->after('foto_bukti');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporans', function (Blueprint $table) {
            // Menghapus kolom jika migration di-rollback
            $table->dropColumn('foto_penanganan');
        });
    }
};