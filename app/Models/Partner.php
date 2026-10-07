<?php

namespace App\Models;

use App\Models\Concerns\Translatable;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use Translatable;

    protected string $translatableMainField = 'role';

    protected $fillable = ['name', 'kind', 'role', 'role_id', 'logo', 'url', 'sort', 'is_published'];

    protected $casts = ['is_published' => 'boolean'];

    public function scopeListed($query)
    {
        return $query->where('is_published', true)->orderBy('sort')->orderBy('id');
    }
}
