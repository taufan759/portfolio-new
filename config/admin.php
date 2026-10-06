<?php

use App\Models\Book;
use App\Models\Certificate;
use App\Models\Message;
use App\Models\Post;
use App\Models\Project;

/*
 * Field types: text, textarea, number, date, select, checkbox, tags (comma separated), image (uploaded, converted to WebP)
 */
return [
    'projects' => [
        'model' => Project::class,
        'label' => 'Projects',
        'order' => ['sort', 'asc'],
        'columns' => ['title', 'category', 'year', 'is_published'],
        'fields' => [
            ['title', 'text', 'rules' => 'required|max:160'],
            ['slug', 'text', 'rules' => 'nullable|max:160', 'help' => 'Leave empty to generate from the title'],
            ['category', 'select', 'options' => ['fullstack' => 'Full-Stack Development', 'uiux' => 'UI/UX Design', 'ai' => 'AI Integration'], 'rules' => 'required|in:fullstack,uiux,ai'],
            ['kind', 'text', 'rules' => 'nullable|max:60', 'help' => 'Short label, e.g. E-commerce'],
            ['year', 'number', 'rules' => 'nullable|integer|min:2000|max:2100'],
            ['description', 'textarea', 'rules' => 'nullable|max:600', 'help' => 'English (main). Used on cards and as the SEO description'],
            ['description_id', 'textarea', 'rules' => 'nullable|max:600', 'help' => 'Indonesian version'],
            ['details', 'textarea', 'rules' => 'nullable', 'rows' => 12, 'help' => 'Case study in Markdown (problem, solution, result), English. Shown on the project page'],
            ['details_id', 'textarea', 'rules' => 'nullable', 'rows' => 12, 'help' => 'Indonesian case study (Markdown)'],
            ['tags', 'tags', 'rules' => 'nullable|max:200', 'help' => 'Comma separated, e.g. Laravel, MySQL'],
            ['image', 'image', 'rules' => 'nullable', 'help' => 'Screenshot, converted to WebP automatically'],
            ['url', 'text', 'rules' => 'nullable|url|max:300'],
            ['sort', 'number', 'rules' => 'nullable|integer|min:0'],
            ['is_published', 'checkbox'],
        ],
    ],
    'certificates' => [
        'model' => Certificate::class,
        'label' => 'Certificates',
        'order' => ['sort', 'asc'],
        'columns' => ['title', 'issuer'],
        'fields' => [
            ['title', 'text', 'rules' => 'required|max:160'],
            ['issuer', 'text', 'rules' => 'nullable|max:160'],
            ['image', 'image', 'rules' => 'nullable'],
            ['url', 'text', 'rules' => 'nullable|url|max:300'],
            ['sort', 'number', 'rules' => 'nullable|integer|min:0'],
        ],
    ],
    'books' => [
        'model' => Book::class,
        'label' => 'Books',
        'order' => ['id', 'desc'],
        'columns' => ['title', 'author', 'status', 'rating'],
        'fields' => [
            ['title', 'text', 'rules' => 'required|max:200'],
            ['author', 'text', 'rules' => 'nullable|max:160'],
            ['status', 'select', 'options' => ['reading' => 'Currently reading', 'finished' => 'Finished', 'wishlist' => 'Wishlist'], 'rules' => 'required|in:reading,finished,wishlist'],
            ['rating', 'number', 'rules' => 'nullable|integer|min:1|max:5', 'help' => '1 to 5'],
            ['finished_at', 'date', 'rules' => 'nullable|date'],
            ['notes', 'textarea', 'rules' => 'nullable|max:2000', 'help' => 'English notes'],
            ['notes_id', 'textarea', 'rules' => 'nullable|max:2000', 'help' => 'Indonesian notes'],
            ['cover', 'image', 'rules' => 'nullable'],
        ],
    ],
    'posts' => [
        'model' => Post::class,
        'label' => 'Blog posts',
        'order' => ['id', 'desc'],
        'columns' => ['title', 'is_published', 'published_at'],
        'fields' => [
            ['title', 'text', 'rules' => 'required|max:200', 'help' => 'English title (main). Leave the Indonesian fields empty if the post exists in one language only'],
            ['title_id', 'text', 'rules' => 'nullable|max:200', 'help' => 'Indonesian title'],
            ['slug', 'text', 'rules' => 'nullable|max:200', 'help' => 'Leave empty to generate from the title. Same URL slug for both languages'],
            ['excerpt', 'textarea', 'rules' => 'nullable|max:400', 'help' => 'English summary, also used as the SEO description'],
            ['excerpt_id', 'textarea', 'rules' => 'nullable|max:400', 'help' => 'Indonesian summary'],
            ['body', 'textarea', 'rules' => 'nullable', 'rows' => 18, 'help' => 'English article, Markdown supported'],
            ['body_id', 'textarea', 'rules' => 'nullable', 'rows' => 18, 'help' => 'Indonesian article, Markdown supported'],
            ['cover', 'image', 'rules' => 'nullable'],
            ['published_at', 'date', 'rules' => 'nullable|date'],
            ['is_published', 'checkbox'],
        ],
    ],
    'messages' => [
        'model' => Message::class,
        'label' => 'Messages',
        'order' => ['id', 'desc'],
        'columns' => ['name', 'email', 'body', 'created_at'],
        'readonly' => true,
        'fields' => [],
    ],
];
