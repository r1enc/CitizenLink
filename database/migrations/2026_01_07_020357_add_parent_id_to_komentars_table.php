<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('komentars', function (Blueprint $table) {
            // Menambahkan kolom parent_id setelah kolom id
            $table->unsignedBigInteger('parent_id')->nullable()->after('id');
            
            // (Opsional) Supaya kalau komentar induk dihapus, balasannya ikut terhapus
            $table->foreign('parent_id')->references('id')->on('komentars')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('komentars', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn('parent_id');
        });
    }
};