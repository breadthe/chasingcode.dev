@extends('_layouts.master')

@push('meta')
    <meta property="og:title" content="{{ $page->title }}" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="{{ $page->getUrl() }}"/>
    <meta property="og:description" content="{{ $page->description }}" />
@endpush

@section('body')
    <section class="p-2 sm:p-6 shadow-xl">
        @if ($page->cover_image)
            <img src="{{ $page->cover_image }}" alt="{{ $page->title }} cover image" class="mb-2">
        @endif

        <h1 class="font-serif text-3xl mb-2">{{ $page->title }}</h1>

        <p class="text-base md:mt-0">
            {{ date('F j, Y', $page->date) }}
        </p>

        @include('_partials.post-hero-image')

        <div class="post border-b border-gray-500 sm:text-2xl font-light text-gray-900 tracking-wide mb-10 pb-4 mt-8 sm:mt-4" v-pre>
            @yield('content')

            @include('_partials.tags')

            @include('_partials.social-share-icons')

            @include('_partials.author')

        </div>

        <nav class="flex justify-between text-sm md:text-base mb-4 sm:mb-0">
            <div>
                @if ($next = $page->getNext())
                    <a href="{{ $next->getUrl() }}" title="Older Post: {{ $next->title }}">
                        &LeftArrow; {{ $next->title }}
                    </a>
                @endif
            </div>

            <div>
                @if ($previous = $page->getPrevious())
                    <a href="{{ $previous->getUrl() }}" title="Newer Post: {{ $previous->title }}">
                        {{ $previous->title }} &RightArrow;
                    </a>
                @endif
            </div>
        </nav>
    </section>
@endsection
