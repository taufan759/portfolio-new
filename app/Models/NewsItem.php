<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsItem extends Model
{
    protected $fillable = ['title','url','source','summary','published_at'];

    protected $casts = ['published_at'=>'datetime'];
}
