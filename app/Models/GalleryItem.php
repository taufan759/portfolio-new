<?php

namespace App\Models;

use App\Models\Concerns\Translatable;
use Illuminate\Database\Eloquent\Model;

class GalleryItem extends Model
{
    use Translatable;

    protected $fillable = [
        'image', 'title', 'title_id', 'caption', 'caption_id', 'location', 'taken_at', 'sort', 'is_published', 'is_featured',
    ];

    protected $casts = ['taken_at' => 'date', 'is_published' => 'boolean', 'is_featured' => 'boolean'];

    /** Published photos, manual order first, then newest event/date, then newest upload. */
    public function scopeListed($query)
    {
        return $query->where('is_published', true)->orderBy('sort')->orderByDesc('taken_at')->orderByDesc('id');
    }
}
