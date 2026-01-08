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
        // Kolom buat nyatet siapa petugas yang nanganin
        $table->foreignId('petugas_id')->nullable()->after('nik_pelapor')->constrained('users')->onDelete('set null');
    });
    }

    public function down(): void
    {
    Schema::table('laporans', function (Blueprint $table) {
        $table->dropForeign(['petugas_id']);
        $table->dropColumn('petugas_id');
    });
    }
};
