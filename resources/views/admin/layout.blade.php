<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex,nofollow">
<link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
<title>@yield('title', 'Admin') — Portfolio</title>
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font:14px/1.5 system-ui,-apple-system,Segoe UI,Roboto,sans-serif;background:#f1f0ee;color:#111}
a{color:inherit;text-decoration:none}
.bar{display:flex;flex-wrap:wrap;align-items:center;gap:.25rem 1rem;padding:.75rem 1.25rem;background:#0a0a0a;color:#fff}
.bar a{padding:.25rem .5rem;border-radius:.5rem;color:rgba(255,255,255,.7)}
.bar a:hover,.bar a.on{color:#fff;background:rgba(255,255,255,.12)}
.bar .sp{flex:1}
.wrap{max-width:60rem;margin:1.5rem auto;padding:0 1rem}
h1{font-size:1.5rem;margin-bottom:1rem}
.card{background:#fff;border-radius:1rem;padding:1.25rem;box-shadow:0 0 0 1px #e6e5e2}
.grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(10rem,1fr));gap:1rem;margin-bottom:1.5rem}
.stat b{display:block;font-size:2rem}
table{width:100%;border-collapse:collapse}
th,td{text-align:left;padding:.625rem .5rem;border-bottom:1px solid #e6e5e2;vertical-align:top}
th{font-size:.75rem;text-transform:uppercase;letter-spacing:.04em;color:#777}
td.t{max-width:22rem;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.btn{display:inline-block;padding:.5rem 1rem;border-radius:.625rem;background:#0a0a0a;color:#fff;border:0;cursor:pointer;font:inherit}
.btn.ghost{background:#fff;color:#111;box-shadow:0 0 0 1px #d7d6d2}
.btn.danger{background:#b3261e}
.row{display:flex;gap:.5rem;align-items:center;flex-wrap:wrap}
label{display:block;font-weight:600;margin:1rem 0 .25rem}
input[type=text],input[type=email],input[type=password],input[type=number],input[type=date],textarea,select{width:100%;padding:.625rem .75rem;border:1px solid #d7d6d2;border-radius:.625rem;font:inherit;background:#fff}
textarea{resize:vertical}
small{color:#777}
.flash{margin-bottom:1rem;padding:.75rem 1rem;border-radius:.75rem;background:#e7f3e7;white-space:pre-line}
.err{color:#b3261e;font-size:.8125rem;margin-top:.25rem}
.thumb{width:6rem;height:4rem;object-fit:cover;border-radius:.5rem;margin-top:.5rem;display:block}
.pager nav>div{display:flex;gap:1rem;margin-top:1rem}
</style>
</head>
<body>
@auth
<div class="bar">
  <strong>Admin</strong>
  <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'on' : '' }}">Dashboard</a>
  @foreach (config('admin') as $key => $def)
    <a href="{{ route('admin.index', $key) }}" class="{{ request()->route('resource') === $key ? 'on' : '' }}">{{ $def['label'] }}</a>
  @endforeach
  <span class="sp"></span>
  <a href="{{ url('/') }}" target="_blank">View site</a>
  <form method="post" action="{{ route('admin.logout') }}">@csrf<button class="btn ghost" style="padding:.25rem .75rem">Logout</button></form>
</div>
@endauth
<div class="wrap">
  @if (session('status'))<div class="flash">{{ session('status') }}</div>@endif
  @yield('content')
</div>
</body>
</html>
