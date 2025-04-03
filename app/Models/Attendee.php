<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Attendee extends Model
{
    /** @use HasFactory<\Database\Factories\AttendeeFactory> */
    use HasFactory;

    public function tickets(): BelongsToMany
    {
        return $this->belongsToMany(Ticket::class);

    }
    public function attendencee(){
        return $this->hasMany(Attendee::class);
    }

    public function ticket_a(){
        return $this->belongsTo(Ticket::class);
    }

    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'registration_date'
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
    
}
