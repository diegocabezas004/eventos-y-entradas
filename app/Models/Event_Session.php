<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event_Session extends Model
{
    /** @use HasFactory<\Database\Factories\SessionFactory> */
    use HasFactory;

    public function events(){
        return $this->belongsTo(Event::class);
    }

    protected $fillable = [

        'event_id',
        'name',
        'location',
        'start_time',
        'end_time',
    ];

}
