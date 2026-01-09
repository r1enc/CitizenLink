<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Laporan extends Model
{
    use HasFactory;

    // Override default Laravel (id) jadi id_laporan
    protected $table = 'laporans';
    protected $primaryKey = 'id_laporan';

    protected $fillable = [
        'nik_pelapor',
        'petugas_id',
        'isi_laporan',
        'lokasi',
        'latitude',
        'longitude',
        'foto_bukti',
        'foto_penanganan',
        'kategori',
        'prioritas',
        'status_laporan',
        'qr_code_path',
        'jumlah_upvote',
        'duplicate_of_id', // ID Induk jika ini duplikat
        'is_manual_category',
        'is_manual_priority',
    ];

    /**
     * Relasi ke Warga (Pelapor) -> Pakai NIK
     */
    public function pelapor()
    {
        return $this->belongsTo(User::class, 'nik_pelapor', 'nik');
    }

    /**
     * Relasi ke Petugas -> Pakai ID biasa
     */
    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id', 'id');
    }

    /**
     * Relasi Self-Join: Satu laporan (Induk) punya banyak duplikat (Anak)
     */
    public function duplicates()
    {
        return $this->hasMany(Laporan::class, 'duplicate_of_id', 'id_laporan');
    }

    /**
     * Accessor: Hitung Deadline otomatis berdasarkan Prioritas
     * Dipanggil via: $laporan->deadline_date
     */
    public function getDeadlineDateAttribute()
    {
        $createdAt = Carbon::parse($this->created_at);

        return match($this->prioritas) {
            'Sangat Tinggi' => $createdAt->addHours(6), // 6 Jam
            'Tinggi'        => $createdAt->addDays(1), // 1 Hari
            'Sedang'        => $createdAt->addDays(2), // 2 Hari 
            'Rendah'        => $createdAt->addWeekdays(2), // 2 Hari Kerja
            default         => $createdAt->addWeekdays(value: 2),
        };
    }
}