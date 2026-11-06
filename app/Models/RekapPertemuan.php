<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapPertemuan extends Model
{
    use HasFactory;
    // Kolom-kolom ini yang akan merekam snapshot angka secara permanen
    protected $fillable = [
        'agenda_lokasi', 'agenda_nama', 'agenda_tanggal', 
        'total_candi', 'total_gunung', 'total_arisan', 'potongan_dansos', 'notulensi'
    ];
}