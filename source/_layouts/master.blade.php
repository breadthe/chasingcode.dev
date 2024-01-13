<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="description" content="{{ $page->description ?? $page->siteDescription }}">

        @stack('meta')

        @if($image = $page->image)
            <meta property="og:image" content="{{ Illuminate\Support\Str::contains($image, 'unsplash.com') ? $image : $page->baseUrl . $image }}" />
        @endif

        <title>{{ $page->siteName }}{{ $page->title ? ' | ' . $page->title : '' }}</title>

        <link rel="home" href="{{ $page->baseUrl }}">

        @include('_partials.favicon')

        <link href="/blog/feed.atom" type="application/atom+xml" rel="alternate" title="{{ $page->siteName }} Blog">

        @if ($page->production)
            @include('_partials.google-analytics')
        @endif

        <link rel="stylesheet" href="{{ mix('css/main.css', 'assets/build') }}">
        <link href="https://github.com/breadthe" rel="me">
        <link rel="webmention" href="https://webmention.io/chasingcode.dev/webmention" />
        <link rel="pingback" href="https://webmention.io/chasingcode.dev/xmlrpc" />
    </head>

    <body class="flex flex-col justify-between bg-gray-100 text-grey-darkest leading-normal font-sans">

        @include('_partials.header')


        <main
            role="main"
            class="flex-auto w-full {{ $page->belongsTo('/blog') || $page->belongsTo('/uses') || $page->belongsTo('/contact') ? 'bg-white max-w-2xl' : 'max-w-6xl' }} mx-auto"
        >
            @yield('hero')

            @yield('body')
        </main>

        @include('_partials.footer')

        <script src="{{ mix('js/main.js', 'assets/build') }}" async></script>

        @stack('scripts')
    </body>
</html>
