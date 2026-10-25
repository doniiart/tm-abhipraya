<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasTua extends Model
{
    use HasFactory;
    protected $fillable = ['tanggal', 'nominal'];
}
