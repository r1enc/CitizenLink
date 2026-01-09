<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'nik',       // Primary Key Logis untuk Warga
        'name',      
        'username',  // Login Petugas
        'email',
        'password',
        'role',      // Penentu Hak Akses (admin/petugas/warga)
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // RELASI KOMUNITAS
    // User bisa bikin banyak Diskusi
    public function diskusis()
    {
        return $this->hasMany(Diskusi::class);
    }

    // User bisa kasih banyak Vote
    public function votes()
    {
        return $this->hasMany(DiskusiVote::class);
    }

    /**
     * Helper/Accessor: Biar bisa panggil {{ $user->nama_lengkap }} di view
     */
    public function getNamaLengkapAttribute()
    {
        return $this->name;
    }
}