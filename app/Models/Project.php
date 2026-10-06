<?php

namespace App\Models;

use App\Models\Concerns\Translatable;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use Translatable;

    protected string $translatableMainField = 'description';

    protected $fillable = ['title','slug','category','kind','year','description','description_id','details','details_id','tags','image','url','sort','is_published'];

    protected $casts = ['tags'=>'array','is_published'=>'boolean'];
}
