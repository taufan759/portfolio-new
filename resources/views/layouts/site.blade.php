<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="csrf-token" content="{{ csrf_token() }}" />
<title>@yield('title', 'Muhammad Taufan Akbar — Full-Stack Developer & AI Enthusiast')</title>
<meta name="description" content="@yield('description', 'Portfolio of Muhammad Taufan Akbar, a Full-Stack Developer & AI Enthusiast building scalable web products, thoughtful interfaces, and intelligent applications.')" />
<meta name="theme-color" content="#0a0a0a" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Onest:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/site.css') }}?v={{ filemtime(public_path('css/site.css')) }}">
</head>
<body>
<a href="#main" class="skip-link">Skip to content</a>

@yield('loader')
@include('partials.header')

<main id="main">
@yield('content')
</main>

@include('partials.footer')
@include('partials.navmenu')
@include('partials.modal')

<script type="importmap">
{ "imports": { "lenis": "https://unpkg.com/lenis@1.3.23/dist/lenis.mjs" } }
</script>
<script type="module" src="{{ asset('js/site.js') }}?v={{ filemtime(public_path('js/site.js')) }}"></script>
</body>
</html>
