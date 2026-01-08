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
            // Kita tambahkan kolom duplicate_of_id
            // Tipe unsignedBigInteger (biar sama kayak ID), dan nullable (karena laporan asli nilainya null)
            $table->unsignedBigInteger('duplicate_of_id')->nullable()->after('status_laporan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporans', function (Blueprint $table) {
            $table->dropColumn('duplicate_of_id');
        });
    }
};