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
    if (!Schema::hasColumn('laporans', 'kategori')) {
        Schema::table('laporans', function (Blueprint $table) {
            // Kita taruh kolom kategori setelah foto bukti
            $table->string('kategori')->default('Lainnya')->after('foto_bukti');
        });
    }
    }

    public function down()
    {
    if (Schema::hasColumn('laporans', 'kategori')) {
        Schema::table('laporans', function (Blueprint $table) {
            $table->dropColumn('kategori');
        });
    }
    }
};
