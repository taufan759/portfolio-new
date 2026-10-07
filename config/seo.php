<?php

/*
 * Only the primary host (and its www) is indexable. Any other host that serves the site (a temporary URL,
 * staging, a local dev domain) gets "noindex", a Disallow-all robots.txt and a canonical pointing to the primary host.
 *
 * The primary host is taken from SEO_PRIMARY_HOST, or from the host in APP_URL. On localhost/.test nothing is indexable.
 */
$appHost = parse_url((string) env('APP_URL', ''), PHP_URL_HOST) ?: null;
$isLocal = $appHost === null || in_array($appHost, ['localhost', '127.0.0.1'], true) || str_ends_with($appHost, '.test');
$primary = env('SEO_PRIMARY_HOST') ?: ($isLocal ? null : $appHost);

return [
    'primary_host' => $primary,
    'indexable_hosts' => $primary ? array_values(array_unique([$primary, 'www.'.$primary])) : [],

    // Crawlers that are explicitly welcome (search, AI search and answer engines). Listed in robots.txt and ai.txt.
    'ai_crawlers' => [
        'GPTBot', 'ChatGPT-User', 'OAI-SearchBot', 'ClaudeBot', 'Claude-User', 'Claude-SearchBot', 'anthropic-ai',
        'PerplexityBot', 'Perplexity-User', 'Google-Extended', 'Applebot-Extended', 'Meta-ExternalAgent', 'Amazonbot',
        'CCBot', 'Diffbot', 'Bytespider', 'DeepSeekBot', 'YouBot', 'cohere-ai', 'MistralAI-User',
    ],

    'search_crawlers' => ['Googlebot', 'Googlebot-Image', 'Bingbot', 'DuckDuckBot', 'YandexBot', 'Slurp', 'Applebot'],

    'social_crawlers' => ['facebookexternalhit', 'Twitterbot', 'LinkedInBot', 'WhatsApp', 'TelegramBot'],
];
