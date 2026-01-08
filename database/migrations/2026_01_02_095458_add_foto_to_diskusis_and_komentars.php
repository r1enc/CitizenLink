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
    Schema::table('diskusis', function (Blueprint $table) {
        $table->string('foto')->nullable()->after('konten');
    });
    Schema::table('komentars', function (Blueprint $table) {
        $table->string('foto')->nullable()->after('isi_komentar');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('diskusis', function (Blueprint $table) {
            //
        });
    }
};
