<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Cek dulu: Kalau kolom 'jumlah_upvote' BELUM ADA, baru tambahin
        if (!Schema::hasColumn('laporans', 'jumlah_upvote')) {
            Schema::table('laporans', function (Blueprint $table) {
                $table->integer('jumlah_upvote')->default(0)->after('status_laporan');
            });
        }
    }

    public function down()
    {
        // Cek dulu: Kalau kolomnya ADA, baru hapus
        if (Schema::hasColumn('laporans', 'jumlah_upvote')) {
            Schema::table('laporans', function (Blueprint $table) {
                $table->dropColumn('jumlah_upvote');
            });
        }
    }
};