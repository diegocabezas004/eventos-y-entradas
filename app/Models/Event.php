<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Event extends Model
{
    /** @use HasFactory<\Database\Factories\EventFactory> */
    use HasFactory;

    public function event_categories(): BelongsToMany 
    {
        return $this->belongsToMany(EventCategory::class);
    }
    
    public function ticket_types(): BelongsToMany
    {
        return $this->belongsToMany(TicketType::class);
    }

    public function sessions(){
        return $this->hasMany(EventSession::class);
    }

    protected $fillable = [
        'organization_id',
        'name',
        'start_date',
        'end_date',
        'location',
        'capacity'
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
