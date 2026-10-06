<?php

return [
    // Public RSS/Atom feeds. Only headline, short excerpt and a link back to the publisher are stored.
    'sources' => [
        'Hacker News' => 'https://hnrss.org/frontpage?points=100',
        'DEV Community' => 'https://dev.to/feed',
        'Laravel News' => 'https://feed.laravel-news.com/',
        'TechCrunch' => 'https://techcrunch.com/feed/',
        'The Verge' => 'https://www.theverge.com/rss/tech/index.xml',
    ],

    // Max items kept per fetch per source, and how long old items are retained.
    'per_source' => 10,
    'keep_days' => 30,
    'timeout' => 10,
];
