<?php

namespace App\Http\Middleware;

use App\Models\PageView;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Counts public page views for the admin dashboard. Stores no IP address and sets no cookie:
 * a visitor is a hash of IP + browser + date + app key, so it cannot be traced back or followed across days.
 * Bots, prefetches, the admin and failed requests are ignored. The insert runs after the response is sent.
 */
class TrackVisit
{
    private const BOTS = '/bot|crawl|spider|slurp|preview|lighthouse|pagespeed|headless|python|curl|wget|http|monitor|uptime|facebookexternalhit|embedly|whatsapp|telegram/i';

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! $request->isMethod('GET') || $request->ajax() || $response->getStatusCode() !== 200) {
            return $response;
        }

        $agent = (string) $request->userAgent();
        if ($agent === '' || preg_match(self::BOTS, $agent) || $request->headers->get('Purpose') === 'prefetch') {
            return $response;
        }

        $path = '/'.ltrim($request->path(), '/');
        $visitor = hash('sha256', $request->ip().'|'.$agent.'|'.now()->toDateString().'|'.config('app.key'));
        $referrer = parse_url((string) $request->headers->get('referer'), PHP_URL_HOST) ?: null;
        $referrer = $referrer && $referrer !== $request->getHost() ? substr($referrer, 0, 120) : null;
        $locale = in_array($request->segment(1), ['id', 'en'], true) ? $request->segment(1) : null;

        app()->terminating(function () use ($path, $locale, $visitor, $referrer) {
            try {
                PageView::create(['path' => substr($path, 0, 255), 'locale' => $locale, 'visitor' => $visitor, 'referrer' => $referrer]);
            } catch (\Throwable) {
                // Analytics must never break a page.
            }
        });

        return $response;
    }
}
