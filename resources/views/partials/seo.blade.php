{{-- SEO otomatis (App\Support\Seo) — dirender server-side, satu kali per halaman. --}}
@php
    $seo = \App\Support\Seo::page();
    $seoTitle = $seo->getTitle();
    $seoShareTitle = $seo->getShareTitle();
    $seoDescription = $seo->getDescription();
    $seoImage = $seo->getImage();
    $seoCanonical = $seo->getCanonical();
    $seoMeta = $seo->getMeta();
@endphp
    <title>{{ $seoTitle }}</title>
    <meta name="description" content="{{ $seoDescription }}">
    <meta name="keywords" content="{{ $seo->getKeywords() }}">
    <meta name="robots" content="{{ $seo->getRobots() }}">
    <meta name="googlebot" content="{{ $seo->getRobots() }}">
    <meta name="author" content="{{ $seoMeta['author'] ?: \App\Support\Seo::SUFFIX }}">
    <link rel="canonical" href="{{ $seoCanonical }}">
    <link rel="alternate" hreflang="id" href="{{ $seoCanonical }}">

    <!-- Open Graph -->
    <meta property="og:site_name" content="{{ \App\Support\Seo::SITE_NAME }}">
    <meta property="og:locale" content="id_ID">
    <meta property="og:type" content="{{ $seo->getType() }}">
    <meta property="og:title" content="{{ $seoShareTitle }}">
    <meta property="og:description" content="{{ $seoDescription }}">
    <meta property="og:url" content="{{ $seoCanonical }}">
    <meta property="og:image" content="{{ $seoImage }}">
    <meta property="og:image:alt" content="{{ $seoShareTitle }}">
@if($seo->getType() === 'article')
@if($seoMeta['published_time'])
    <meta property="article:published_time" content="{{ $seoMeta['published_time'] }}">
@endif
@if($seoMeta['modified_time'])
    <meta property="article:modified_time" content="{{ $seoMeta['modified_time'] }}">
@endif
@if($seoMeta['section'])
    <meta property="article:section" content="{{ $seoMeta['section'] }}">
@endif
@endif

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seoShareTitle }}">
    <meta name="twitter:description" content="{{ $seoDescription }}">
    <meta name="twitter:image" content="{{ $seoImage }}">

    <!-- Data terstruktur -->
@foreach($seo->getSchemas() as $schema)
    <script type="application/ld+json">{!! json_encode(array_filter($schema, fn ($v) => $v !== null && $v !== ''), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
@endforeach
    <link rel="sitemap" type="application/xml" title="Sitemap" href="{{ route('sitemap') }}">
