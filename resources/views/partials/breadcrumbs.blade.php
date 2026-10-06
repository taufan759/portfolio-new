{{-- $crumbs: [[label, url], ...] ending with the current page --}}
<nav class="breadcrumbs" aria-label="Breadcrumb">
  <ol>
    @foreach ($crumbs as [$label, $url])
      <li>@if ($loop->last)<span aria-current="page">{{ $label }}</span>@else<a href="{{ $url }}">{{ $label }}</a>@endif</li>
    @endforeach
  </ol>
</nav>
@push('jsonld')
{!! \App\Support\Seo::script(\App\Support\Seo::breadcrumbs($crumbs)) !!}
@endpush
