<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengeluaranBendahara extends Model
{
    use HasFactory;
    
    // Izinkan form menyimpan ke 3 kolom ini
    protected $fillable = ['tanggal', 'nominal', 'keperluan'];
}
