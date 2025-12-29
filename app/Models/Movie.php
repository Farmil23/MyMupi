<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'genre',
        'poster',
        'synopsis',
        'duration_minutes',
        'release_date',
        'rating',
        'trailer_url',
    ];
    
    public function showtimes()
    {
        return $this->hasMany(\App\Models\Showtime::class);
    }

    public function reviews()
    {
        return $this->hasMany(\App\Models\Review::class);
    }
}
