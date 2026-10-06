<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Model;

/** Builds schema.org JSON-LD (kept in PHP so Blade never has to parse "@" keys). */
class Seo
{
    public static function script(array $data): string
    {
        $data = ['@context' => 'https://schema.org'] + $data;

        return '<script type="application/ld+json">'
            .json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP)
            .'</script>';
    }

    public static function siteScript(): string
    {
        return self::script(['@graph' => [self::person(), self::website()]]);
    }

    public static function personId(): string
    {
        return rtrim(url('/'), '/').'/#person';
    }

    public static function person(): array
    {
        $site = config('site');

        return [
            '@type' => 'Person',
            '@id' => self::personId(),
            'name' => $site['name'],
            'alternateName' => $site['short_name'],
            'url' => url('/'),
            'image' => asset($site['og_image']),
            'email' => $site['email'],
            'jobTitle' => \App\Models\Profile::current()->text('headline'),
            'description' => \App\Models\Profile::current()->text('intro'),
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => $site['city'],
                'addressRegion' => $site['region'],
                'addressCountry' => $site['country'],
            ],
            'alumniOf' => ['@type' => 'CollegeOrUniversity', 'name' => $site['university']],
            'knowsAbout' => $site['knows_about'],
            'knowsLanguage' => ['id', 'en'],
            'sameAs' => array_values($site['social']),
        ];
    }

    public static function website(): array
    {
        return [
            '@type' => 'WebSite',
            '@id' => rtrim(url('/'), '/').'/#website',
            'url' => url('/'),
            'name' => config('site.name'),
            'inLanguage' => ['id', 'en'],
            'publisher' => ['@id' => self::personId()],
        ];
    }

    /** @param  array<int, array{0:string,1:string}>  $crumbs  [label, url] pairs, in order */
    public static function breadcrumbs(array $crumbs): array
    {
        return [
            '@type' => 'BreadcrumbList',
            'itemListElement' => collect($crumbs)->values()->map(fn ($c, $i) => [
                '@type' => 'ListItem', 'position' => $i + 1, 'name' => $c[0], 'item' => $c[1],
            ])->all(),
        ];
    }

    /** @param  array<int, array{0:string,1:string}>  $qa  [question, answer] pairs */
    public static function faq(array $qa): array
    {
        return [
            '@type' => 'FAQPage',
            'mainEntity' => collect($qa)->map(fn ($x) => [
                '@type' => 'Question', 'name' => $x[0],
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $x[1]],
            ])->all(),
        ];
    }

    /**
     * Which single locale a translatable record exists in; '' when it exists in both
     * (or neither), meaning canonical stays on the current locale and hreflang is emitted.
     */
    public static function onlyLocale(Model $model): string
    {
        $id = $model->isTranslated('id');
        $en = $model->isTranslated('en');

        return $id === $en ? '' : ($id ? 'id' : 'en');
    }
}
