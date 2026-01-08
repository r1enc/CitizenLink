<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Kita ubah kolom status_laporan biar bisa nampung 'ditolak'
        // Pakai Raw Statement biar aman & pasti jalan di MySQL
        DB::statement("ALTER TABLE laporans MODIFY COLUMN status_laporan ENUM('0', 'proses', 'selesai', 'ditolak') DEFAULT '0'");
    }

    public function down()
    {
        // Balikin ke asal (opsional)
        DB::statement("ALTER TABLE laporans MODIFY COLUMN status_laporan ENUM('0', 'proses', 'selesai') DEFAULT '0'");
    }
};