<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diskusi extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'judul', 'konten', 'kategori', 'foto'];

    // Penulis diskusi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Jumlah vote/dukungan di diskusi
    public function votes()
    {
        return $this->hasMany(DiskusiVote::class);
    }

    // Daftar komentar di diskusi ini
    public function komentars()
    {
        return $this->hasMany(Komentar::class);
    }
}