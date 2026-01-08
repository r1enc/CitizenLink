<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Buang dulu kolom 'prioritas' yang lama (beserta isinya yang bikin error)
        if (Schema::hasColumn('laporans', 'prioritas')) {
            Schema::table('laporans', function (Blueprint $table) {
                $table->dropColumn('prioritas');
            });
        }

        // 2. Bikin lagi kolom 'prioritas' yang baru dengan tipe String (Teks)
        Schema::table('laporans', function (Blueprint $table) {
            $table->string('prioritas')->default('Normal')->after('status_laporan');
        });
    }

    public function down()
    {
        // Kalau dibatalkan, hapus kolomnya
        if (Schema::hasColumn('laporans', 'prioritas')) {
            Schema::table('laporans', function (Blueprint $table) {
                $table->dropColumn('prioritas');
            });
        }
    }
};