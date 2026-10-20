<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iuran extends Model
{
    use HasFactory;
    protected $fillable = [
        'anggota_id',
        'tanggal',
        'tempat',
        'arisan',
        'tabungan',
        'dansos'
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }
}
