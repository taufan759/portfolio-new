<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public const LOCALES = ['id', 'en'];

    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->route('locale');

        abort_unless(in_array($locale, self::LOCALES, true), 404);

        app()->setLocale($locale);
        URL::defaults(['locale' => $locale]);
        // Controllers do not need the locale argument.
        $request->route()->forgetParameter('locale');

        Cookie::queue('lang', $locale, 60 * 24 * 365);

        return $next($request);
    }
}
