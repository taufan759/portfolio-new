<?php

namespace App\Models;

use App\Models\Concerns\Translatable;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use Translatable;

    protected string $translatableMainField = 'description';

    protected $fillable = [
        'title', 'title_id', 'organizer', 'location', 'role', 'role_id', 'description', 'description_id',
        'held_at', 'year', 'sort', 'is_published',
    ];

    protected $casts = ['held_at' => 'date', 'is_published' => 'boolean'];

    /** Newest year first; within a year, manual order. */
    public function scopeListed($query)
    {
        return $query->where('is_published', true)->orderByDesc('year')->orderBy('sort')->orderByDesc('id');
    }
}
