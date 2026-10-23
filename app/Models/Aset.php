<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aset extends Model
{
    use HasFactory;

    // Mengizinkan kolom ini diisi secara massal lewat form
    protected $fillable = [
        'nama_aset',
        'jumlah',
        'kondisi'
    ];
}
