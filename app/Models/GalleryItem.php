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

    /** Small version for the grid when one exists (image.webp -> image-sm.webp), otherwise the full image. */
    public function thumb(): string
    {
        $small = preg_replace('/\.webp$/', '-sm.webp', $this->image);

        return $small !== $this->image && is_file(public_path($small)) ? $small : $this->image;
    }

    /** @return array{0:int,1:int} width and height of the grid image, so the layout does not jump while loading */
    public function thumbSize(): array
    {
        $info = @getimagesize(public_path($this->thumb()));

        return $info ? [$info[0], $info[1]] : [600, 450];
    }
}
