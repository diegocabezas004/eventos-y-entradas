<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event_Category extends Model
{
    /** @use HasFactory<\Database\Factories\EventCategoryFactory> */
    use HasFactory;
        protected $fillable = [
        'category'
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
