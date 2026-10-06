<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** The site owner's personal copy (headline, intro, about text). Editable in admin; defaults live in the lang folder (site.php per language). */
class Profile extends Model
{
    protected $fillable = [
        'headline', 'headline_id', 'intro', 'intro_id', 'summary', 'summary_id', 'story', 'story_id',
        'location', 'location_id', 'education', 'education_id', 'availability', 'availability_id', 'skills',
    ];

    protected $casts = ['skills' => 'array'];

    private static ?self $current = null;

    public static function current(): self
    {
        return self::$current ??= (self::query()->first() ?? new self);
    }

    /** Text in the current language; when empty, the built-in default for that same language. */
    public function text(string $field): string
    {
        $value = app()->getLocale() === 'id' ? $this->{$field.'_id'} : $this->{$field};

        return filled($value) ? (string) $value : (string) __('site.profile.'.$field);
    }

    /** @return array<int, string> */
    public function skillList(): array
    {
        return $this->skills ?: config('site.skills');
    }
}
