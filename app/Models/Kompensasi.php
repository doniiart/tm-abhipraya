<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kompensasi extends Model
{
    use HasFactory;

    // Tambahkan baris ini agar data bisa di-input
    protected $fillable = [
        'tanggal',
        'sumber_dana',
        'nominal'
    ];
}
