@extends('_layouts.master')

@push('meta')
    <meta property="og:title" content="{{ $page->title }}" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="{{ $page->getUrl() }}"/>
    <meta property="og:description" content="{{ $page->description }}" />
@endpush

@section('body')
    <article class="p-4 sm:p-6 bg-white rounded">
        <header class="mb-2">
            @if ($page->cover_image)
                <img src="{{ $page->cover_image }}" alt="{{ $page->title }} cover image" class="mb-2">
            @endif

            <h1 class="font-serif text-3xl mb-1 md:mb-2">{{ $page->title }}</h1>

            <div class="flex flex-col md:flex-row gap-2">
                <small class="font-mono">
                    by <a href="/about">webmaster</a>
                </small>

                <small class="hidden md:block">&bull;</small>

                <small class="font-mono">
                    {{ date('F j, Y', $page->date) }}
                </small>

                <small class="hidden md:block">&bull;</small>

                <x-tags :tags="$page->categories" />
            </div>

            @if($page->updated)
                <div class="mt-2">
                    <small class="font-mono">
                        <strong>Updated: </strong>
                        {{ date('F j, Y', $page->updated) }}
                    </small>
                </div>
            @endif

            @include('_partials.post-hero-image')
        </header>

        <div class="post font-light text-gray-900 tracking-wide pb-4" v-pre>
            @yield('content')

            @include('_partials.social-share-icons')
        </div>

        @include('_partials.mastodon-webmention')

        {{--@include('_partials.author')--}}

        <nav class="flex justify-between text-sm md:text-base my-4 sm:mb-0">
            <div>
                @if ($next = $page->getNext())
                    <a href="{{ $next->getUrl() }}" class="no-underline" title="Older Post: {{ $next->title }}">
                        &LeftArrow; {{ $next->title }}
                    </a>
                @endif
            </div>

            <div>
                @if ($previous = $page->getPrevious())
                    <a href="{{ $previous->getUrl() }}" class="no-underline" title="Newer Post: {{ $previous->title }}">
                        {{ $previous->title }} &RightArrow;
                    </a>
                @endif
            </div>
        </nav>
    </article>
@endsection
