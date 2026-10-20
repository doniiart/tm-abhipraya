<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'kategori',
        'deskripsi',
        'foto',
        'user_id'
    ];

    // Relasi untuk mengetahui siapa yang mengupload foto ini
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}