<?php

return [
    // Indonesian public RSS/Atom feeds. Only headline, short excerpt and a link back to the publisher are stored.
    // 'filter' => true keeps only items matching the keywords below (general tech outlets).
    // 'filter' => false keeps every item (already developer-focused).
    // 'lang' decides which language version of the site shows the items: id = Indonesian pages, en = English pages.
    'sources' => [
        // Indonesian media (Indonesian pages)
        'Dicoding' => ['url' => 'https://www.dicoding.com/blog/feed/', 'filter' => false, 'lang' => 'id'],
        'Liputan6 Tekno' => ['url' => 'https://feed.liputan6.com/rss/tekno', 'filter' => true, 'lang' => 'id'],
        'CNN Indonesia Teknologi' => ['url' => 'https://www.cnnindonesia.com/teknologi/rss', 'filter' => true, 'lang' => 'id'],
        'Antara Tekno' => ['url' => 'https://www.antaranews.com/rss/tekno.xml', 'filter' => true, 'lang' => 'id'],
        'JagatReview' => ['url' => 'https://www.jagatreview.com/feed/', 'filter' => true, 'lang' => 'id'],

        // International media (English pages)
        'Laravel News' => ['url' => 'https://feed.laravel-news.com/', 'filter' => false, 'lang' => 'en'],
        'TechCrunch AI' => ['url' => 'https://techcrunch.com/category/artificial-intelligence/feed/', 'filter' => false, 'lang' => 'en'],
        'OpenAI News' => ['url' => 'https://openai.com/news/rss.xml', 'filter' => false, 'lang' => 'en'],
        'Search Engine Journal' => ['url' => 'https://www.searchenginejournal.com/feed/', 'filter' => true, 'lang' => 'en'],
        'InfoQ' => ['url' => 'https://www.infoq.com/feed/', 'filter' => true, 'lang' => 'en'],
        'Smashing Magazine' => ['url' => 'https://www.smashingmagazine.com/feed/', 'filter' => false, 'lang' => 'en'],
        'The Verge' => ['url' => 'https://www.theverge.com/rss/tech/index.xml', 'filter' => true, 'lang' => 'en'],
    ],

    // Relevance to web/full-stack development, UI/UX and AI integration. Whole-word, case-insensitive.
    'keywords' => [
        'ai', 'kecerdasan buatan', 'chatgpt', 'openai', 'gemini', 'claude', 'llm', 'machine learning', 'chatbot',
        'developer', 'programmer', 'pemrograman', 'coding', 'software', 'perangkat lunak', 'open source', 'github',
        'laravel', 'php', 'javascript', 'python', 'react', 'api', 'website', 'web', 'framework', 'database',
        'cloud', 'server', 'hosting', 'startup', 'ui', 'ux', 'desain', 'figma',
        'keamanan siber', 'siber', 'peretasan', 'data pribadi', 'google', 'microsoft',
    ],

    // Relevance filter for English sources (whole words, case-insensitive).
    'keywords_en' => [
        'ai', 'llm', 'chatbot', 'machine learning', 'agent', 'agents', 'openai', 'anthropic', 'claude', 'gemini',
        'developer', 'developers', 'programming', 'software', 'open source', 'github', 'laravel', 'php', 'javascript',
        'python', 'react', 'api', 'web', 'framework', 'database', 'cloud', 'server', 'hosting', 'startup', 'ux', 'ui',
        'design', 'security', 'seo', 'search', 'automation', 'data',
    ],

    // Max items read per source per fetch, and how long old items are retained.
    'per_source' => 15,
    'keep_days' => 30,
    'timeout' => 10,

    // Auto refresh when someone opens the site and data is older than this (minutes). Works without cron.
    'refresh_minutes' => 60,
];
