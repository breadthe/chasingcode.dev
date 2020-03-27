<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="description" content="{{ $page->description ?? $page->siteDescription }}">

        <meta property="og:title" content="{{ $page->title ?  $page->title . ' | ' : '' }}{{ $page->siteName }}"/>
        <meta property="og:type" content="website" />
        <meta property="og:url" content="{{ $page->getUrl() }}"/>
        <meta property="og:description" content="{{ $page->description ?? $page->siteDescription }}" />
        @if($image = $page->image)
            <meta property="og:image" content="{{ Illuminate\Support\Str::contains($image, 'unsplash.com') ? $image : $page->baseUrl . $image }}" />
        @endif

        <title>{{ $page->siteName }}{{ $page->title ? ' | ' . $page->title : '' }}</title>

        <link rel="home" href="{{ $page->baseUrl }}">

        @include('_partials.favicon')

        <link href="/blog/feed.atom" type="application/atom+xml" rel="alternate" title="{{ $page->siteName }} Blog">

        @stack('meta')

        @if ($page->production)
            @include('_partials.google-analytics')
        @endif

        <link href="https://fonts.googleapis.com/css?family=Lato:100,200,300,400,500,600,700,800,900|Bitter" rel="stylesheet">
        <link rel="stylesheet" href="{{ mix('css/main.css', 'assets/build') }}">
    </head>

    <body class="flex flex-col justify-between bg-gray-100 text-grey-darkest leading-normal font-sans">

        @include('_partials.header')


        <main role="main" class="flex-auto w-full {{ $page->belongsTo('/blog') || $page->belongsTo('/uses') || $page->belongsTo('/contact') ? 'bg-white max-w-4xl' : 'max-w-6xl' }} mx-auto">
            @yield('hero')

            @yield('body')
        </main>

        @include('_partials.footer')

        <script src="{{ mix('js/main.js', 'assets/build') }}"></script>

        @stack('scripts')
    </body>
</html>
