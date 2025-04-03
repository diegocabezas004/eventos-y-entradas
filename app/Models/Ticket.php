<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    /** @use HasFactory<\Database\Factories\TicketFactory> */
    use HasFactory;

    public function ticket_type(){
        return $this->belongsTo(TicketType::class);
    }

    public function attendees(){
        return $this->hasMany(Attendee::class);
    }

    protected $fillable = [
        'ticket_type_id',
        'ticket_unique_code',
        'purchase_date',
        'checked_in',
        'attendee_id',
    ];

    protected function casts(): array{
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime'
        ];
    }
}
