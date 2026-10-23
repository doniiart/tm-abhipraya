<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sewa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_penyewa',
        'alamat',
        'aset_id',
        'jumlah_pinjam',
        'tanggal_sewa',
        'status'
    ];

    // Relasi ke tabel Aset (Satu Data Sewa milik Satu Aset)
    public function aset()
    {
        return $this->belongsTo(Aset::class);
    }
}