<?php

return [
    // Indonesian public RSS/Atom feeds. Only headline, short excerpt and a link back to the publisher are stored.
    // 'filter' => true keeps only items matching the keywords below (general tech outlets).
    // 'filter' => false keeps every item (already developer-focused).
    'sources' => [
        'Dicoding' => ['url' => 'https://www.dicoding.com/blog/feed/', 'filter' => false],
        'Liputan6 Tekno' => ['url' => 'https://feed.liputan6.com/rss/tekno', 'filter' => true],
        'CNN Indonesia Teknologi' => ['url' => 'https://www.cnnindonesia.com/teknologi/rss', 'filter' => true],
        'Antara Tekno' => ['url' => 'https://www.antaranews.com/rss/tekno.xml', 'filter' => true],
        'JagatReview' => ['url' => 'https://www.jagatreview.com/feed/', 'filter' => true],
    ],

    // Relevance to web/full-stack development, UI/UX and AI integration. Whole-word, case-insensitive.
    'keywords' => [
        'ai', 'kecerdasan buatan', 'chatgpt', 'openai', 'gemini', 'claude', 'llm', 'machine learning', 'chatbot',
        'developer', 'programmer', 'pemrograman', 'coding', 'software', 'perangkat lunak', 'open source', 'github',
        'laravel', 'php', 'javascript', 'python', 'react', 'api', 'website', 'web', 'framework', 'database',
        'cloud', 'server', 'hosting', 'startup', 'ui', 'ux', 'desain', 'figma',
        'keamanan siber', 'siber', 'peretasan', 'data pribadi', 'google', 'microsoft',
    ],

    // Max items read per source per fetch, and how long old items are retained.
    'per_source' => 15,
    'keep_days' => 30,
    'timeout' => 10,

    // Auto refresh when someone opens the site and data is older than this (minutes). Works without cron.
    'refresh_minutes' => 60,
];
