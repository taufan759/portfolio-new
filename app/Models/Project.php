<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['title','slug','category','kind','year','description','tags','image','url','sort','is_published'];

    protected $casts = ['tags'=>'array','is_published'=>'boolean'];
}
