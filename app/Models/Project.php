<?php

namespace App\Models;

use App\Models\Concerns\Translatable;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use Translatable;

    protected string $translatableMainField = 'description';

    protected $fillable = ['title','slug','category','kind','year','description','description_id','details','details_id','tags','image','url','sort','is_published','is_featured'];

    protected $casts = ['tags'=>'array','is_published'=>'boolean','is_featured'=>'boolean'];

    /** Published projects in display order: manual "sort" first, then newest. */
    public function scopeListed($query)
    {
        return $query->where('is_published', true)->orderBy('sort')->orderByDesc('id');
    }
}
