<?php

namespace App\Models;

use App\Models\Concerns\Translatable;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use Translatable;

    protected string $translatableMainField = 'description';

    protected $fillable = ['title','slug','category','categories','kind','year','description','description_id','details','details_id','tags','image','url','sort','is_published','is_featured'];

    protected $casts = ['tags'=>'array','categories'=>'array','is_published'=>'boolean','is_featured'=>'boolean'];

    /** Small image for cards (the "-sm" variant) when it exists, otherwise the full image. */
    public function thumb(): string
    {
        $small = preg_replace('/\.webp$/', '-sm.webp', (string) $this->image);

        return $small !== $this->image && is_file(public_path($small)) ? $small : (string) $this->image;
    }

    /** All categories the project belongs to (the primary one first). */
    public function allCategories(): array
    {
        return array_values(array_unique(array_filter(array_merge([$this->category], $this->categories ?? []))));
    }

    /** Published projects in display order: manual "sort" first, then newest. */
    public function scopeListed($query)
    {
        return $query->where('is_published', true)->orderBy('sort')->orderByDesc('id');
    }
}
