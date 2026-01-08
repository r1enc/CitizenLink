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
    Schema::table('laporans', function (Blueprint $table) {
        $table->boolean('is_manual_category')->default(0)->after('kategori');
        $table->boolean('is_manual_priority')->default(0)->after('prioritas');
    });
    }

    public function down()
    {
    Schema::table('laporans', function (Blueprint $table) {
        $table->dropColumn(['is_manual_category', 'is_manual_priority']);
    });
    }
};
