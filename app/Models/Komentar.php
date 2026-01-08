<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    use HasFactory;
    
    // parent_id terisi jika ini adalah balasan komentar (Nested Comment)
    protected $fillable = ['user_id', 'diskusi_id', 'isi_komentar', 'foto', 'parent_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function diskusi() {
        return $this->belongsTo(Diskusi::class);
    }
}