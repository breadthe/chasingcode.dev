@extends('_layouts.master')

@push('meta')
    <meta property="og:title" content="{{ $page->title }}" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="{{ $page->getUrl() }}"/>
    <meta property="og:description" content="{{ $page->description }}" />
@endpush

@section('body')
    @if ($page->cover_image)
        <img src="{{ $page->cover_image }}" alt="{{ $page->title }} cover image" class="mb-2">
    @endif

    <h1 class="font-serif font-light text-4xl text-pink-dark leading-normal text-center mb-2">{{ $page->title }}</h1>

    <p class="text-grey-darker text-md text-center md:mt-0">
        {{ $page->author }}  •  {{ date('F j, Y', $page->date) }}
    </p>

    @include('_partials.post-hero-image')

    <div class="border-b border-pink text-2xl font-light text-grey-darkest mb-10 pb-4" v-pre>
        @yield('content')

        @if ($page->categories)
            @foreach ($page->categories as $i => $category)
                <a
                        href="{{ '/blog/categories/' . $category }}"
                        title="View posts in {{ $category }}"
                        class="inline-block bg-pink-lighter hover:bg-pink leading-loose tracking-wide text-white hover:text-white uppercase text-xs font-semibold rounded mr-4 px-3 pt-px"
                >{{ $category }}</a>
            @endforeach
        @endif

    </div>

    <nav class="flex justify-between text-sm md:text-base">
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
@endsection
