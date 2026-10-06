<?php

namespace App\Models\Concerns;

/**
 * Two-language content: the plain column is English, the "{column}_id" column is Indonesian.
 * t() returns the current locale's text and falls back to the other language when empty.
 */
trait Translatable
{
    public function t(string $field): mixed
    {
        $en = $this->{$field};
        $id = $this->{$field.'_id'};

        if (app()->getLocale() === 'id') {
            return filled($id) ? $id : $en;
        }

        return filled($en) ? $en : $id;
    }

    /** Does this record have real content for the given locale? (used for canonical/hreflang decisions) */
    public function isTranslated(string $locale): bool
    {
        $field = $this->translatableMainField ?? 'title';

        return $locale === 'id' ? filled($this->{$field.'_id'}) : filled($this->{$field});
    }
}
