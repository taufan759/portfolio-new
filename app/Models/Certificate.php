<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    /** Title for the current language: English pages use the English equivalent when there is one. */
    public function label(): string
    {
        return app()->getLocale() === 'en' && filled($this->title_en) ? $this->title_en : (string) $this->title;
    }

    protected $fillable = ['title','title_en','issuer','image','url','sort'];
}
