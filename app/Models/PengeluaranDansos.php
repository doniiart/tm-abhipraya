<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengeluaranDansos extends Model
{
    use HasFactory;

    protected $fillable = ['jenis', 'keterangan', 'nominal', 'tanggal'];
}
