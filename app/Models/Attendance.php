<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    /** @use HasFactory<\Database\Factories\AttendanceFactory> */
    use HasFactory;

    protected $fillable = [
        'session_id',
        'attendee_id',
        'validated_by_user_id',
    ];

    protected function casts(): array
    {
        return [
            'check_in_time' => 'datetime',
        ];
    }
}
