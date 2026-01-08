<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sla_rules', function (Blueprint $table) {
            $table->id();
            $table->string('kategori');   // Contoh: Infrastruktur
            $table->string('keyword');    // Contoh: aspal rusak
            $table->string('prioritas');  // Contoh: Tinggi
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sla_rules');
    }
};