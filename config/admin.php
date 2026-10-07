<?php

use App\Models\Book;
use App\Models\Certificate;
use App\Models\Message;
use App\Models\Post;
use App\Models\Profile;
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
            ['is_featured', 'checkbox'],
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
            ['title', 'text', 'rules' => 'required_without:title_id|nullable|max:200', 'help' => 'English title. Leave the English fields empty if the post is written in Indonesian only'],
            ['title_id', 'text', 'rules' => 'nullable|max:200', 'help' => 'Indonesian title'],
            ['slug', 'text', 'rules' => 'nullable|max:200', 'help' => 'Leave empty to generate from the title. Same URL slug for both languages'],
            ['excerpt', 'textarea', 'rules' => 'nullable|max:400', 'help' => 'English summary, also used as the SEO description'],
            ['excerpt_id', 'textarea', 'rules' => 'nullable|max:400', 'help' => 'Indonesian summary'],
            ['body', 'textarea', 'rules' => 'nullable', 'rows' => 18, 'help' => 'English article, Markdown supported'],
            ['body_id', 'textarea', 'rules' => 'nullable', 'rows' => 18, 'help' => 'Indonesian article, Markdown supported'],
            ['cover', 'image', 'rules' => 'nullable'],
            ['source_url', 'text', 'rules' => 'nullable|url|max:300', 'help' => 'Link to the original (e.g. the Medium article). Shown as "Originally published on ..."'],
            ['published_at', 'date', 'rules' => 'nullable|date'],
            ['is_published', 'checkbox'],
        ],
    ],
    'profile' => [
        'model' => Profile::class,
        'label' => 'Profile',
        'order' => ['id', 'asc'],
        'columns' => ['headline'],
        'single' => true,
        'fields' => [
            ['headline', 'text', 'rules' => 'nullable|max:160', 'help' => 'Role line under your name, English. Leave empty to use the default'],
            ['headline_id', 'text', 'rules' => 'nullable|max:160', 'help' => 'Indonesian'],
            ['intro', 'textarea', 'rules' => 'nullable|max:500', 'help' => 'Short introduction on the home page (1-2 sentences), English'],
            ['intro_id', 'textarea', 'rules' => 'nullable|max:500', 'help' => 'Indonesian'],
            ['summary', 'textarea', 'rules' => 'nullable|max:700', 'help' => 'Opening paragraph of the About page, English'],
            ['summary_id', 'textarea', 'rules' => 'nullable|max:700', 'help' => 'Indonesian'],
            ['story', 'textarea', 'rules' => 'nullable', 'rows' => 12, 'help' => 'Your background and approach in Markdown, English'],
            ['story_id', 'textarea', 'rules' => 'nullable', 'rows' => 12, 'help' => 'Indonesian'],
            ['location', 'text', 'rules' => 'nullable|max:160', 'help' => 'e.g. Tegal, Central Java, Indonesia'],
            ['location_id', 'text', 'rules' => 'nullable|max:160'],
            ['education', 'text', 'rules' => 'nullable|max:200', 'help' => 'e.g. B.Sc. Information Systems, Universitas Bina Sarana Informatika'],
            ['education_id', 'text', 'rules' => 'nullable|max:200'],
            ['availability', 'text', 'rules' => 'nullable|max:200', 'help' => 'e.g. Open to remote work and collaboration'],
            ['availability_id', 'text', 'rules' => 'nullable|max:200'],
            ['skills', 'tags', 'rules' => 'nullable|max:600', 'help' => 'Tools and technologies, comma separated. Same list for both languages'],
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
