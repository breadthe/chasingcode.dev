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

    <h1 class="font-serif text-4xl leading-normal text-center mb-2">{{ $page->title }}</h1>

    <p class="text-grey-darker text-md text-center md:mt-0">
        {{ $page->author }}  •  {{ date('F j, Y', $page->date) }}
    </p>

    @include('_partials.post-hero-image')

    <div class="post border-b border-gray-500 text-2xl font-light text-grey-darkest mb-10 pb-4" v-pre>
        @yield('content')

        @if ($page->categories)
            @foreach ($page->categories as $i => $category)
                <a
                        href="{{ '/blog/categories/' . $category }}"
                        title="View posts in {{ $category }}"
                        class="bg-teal-100 px-2 border border-dashed border-teal-400 hover:bg-teal-400 hover:text-teal-100 text-xl rounded px-1"
                        style="background-image: none;"
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
