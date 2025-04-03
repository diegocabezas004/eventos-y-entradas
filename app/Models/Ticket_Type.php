<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket_Type extends Model
{
    /** @use HasFactory<\Database\Factories\TicketTypeFactory> */
    use HasFactory;

    public function ticket(){
        return $this->hasMany(Ticket::class);
    }

    protected $fillable = [
        'event_id',
        'name',
        'price',
        'quantity_available',
        'sales_start',
        'sales_end'
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
