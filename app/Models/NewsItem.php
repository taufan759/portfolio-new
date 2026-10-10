<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsItem extends Model
{
    protected $fillable = ['title','url','source','lang','summary','published_at'];

    /** Items for one language version of the site (id or en). */
    public function scopeForLocale($query, ?string $locale = null)
    {
        return $query->where('lang', $locale ?? app()->getLocale());
    }

    protected $casts = ['published_at'=>'datetime'];
}
