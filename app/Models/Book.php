<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['title','author','status','rating','finished_at','notes','cover'];

    protected $casts = ['finished_at'=>'date'];
}
