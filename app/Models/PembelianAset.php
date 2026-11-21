<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembelianAset extends Model
{
    protected $fillable = [
        'nama_barang',
        'jumlah',
        'tanggal_pembelian',
        'total_harga',
        'nota',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}