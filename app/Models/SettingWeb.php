<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingWeb extends Model
{
    use HasFactory;
    protected $fillable = [
    'agenda_nama', 'agenda_lokasi', 'agenda_waktu', 'agenda_tanggal', 'agenda_bulan', 'agenda_target_countdown',
    'stat_anggota', 'stat_kas', 'stat_sosial',
    'nama_organisasi', 'deskripsi', 'tahun_berdiri' // Tambahkan baris ini
];
}
