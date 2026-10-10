<?php

namespace App\Models;

use App\Models\Concerns\Translatable;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use Translatable;

    protected $fillable = ['title','title_id','slug','excerpt','excerpt_id','body','body_id','cover','source_url','published_at','is_published'];

    /** Posts that exist in the given language (English: "title" filled, Indonesian: "title_id" filled). */
    public function scopeForLocale($query, ?string $locale = null)
    {
        $column = ($locale ?? app()->getLocale()) === 'id' ? 'title_id' : 'title';

        return $query->whereNotNull($column)->where($column, '!=', '');
    }

    protected $casts = ['published_at'=>'datetime','is_published'=>'boolean'];
}
