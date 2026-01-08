<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanDukungan extends Model
{
    use HasFactory;
    
    // Mencatat user_id vote ke id_laporan (Mencegah double vote)
    protected $fillable = ['user_id', 'id_laporan'];
}