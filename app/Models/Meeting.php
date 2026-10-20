<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $fillable = [
        'title', 'date', 'javanese_date', 'location', 
        'host_name', 'status', 'created_by'
    ];

    public function agendas()
    {
        return $this->hasMany(MeetingAgenda::class)->orderBy('order_no', 'asc');
    }

    public function attendances()
    {
        return $this->hasMany(MeetingAttendance::class);
    }
}
