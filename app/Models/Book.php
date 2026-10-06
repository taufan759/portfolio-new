<?php

namespace App\Models;

use App\Models\Concerns\Translatable;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use Translatable;

    protected $fillable = ['title','author','status','rating','finished_at','notes','notes_id','cover'];

    protected $casts = ['finished_at'=>'date'];
}
