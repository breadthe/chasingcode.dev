@extends('_layouts.master')

@push('meta')
    <meta property="og:title" content="{{ $page->title }}" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="{{ $page->getUrl() }}"/>
    <meta property="og:description" content="{{ $page->description }}" />
@endpush

@section('body')
    <section class="p-6 shadow-xl">
        @if ($page->cover_image)
            <img src="{{ $page->cover_image }}" alt="{{ $page->title }} cover image" class="mb-2">
        @endif

        <h1 class="font-serif text-4xl text-center mb-2">{{ $page->title }}</h1>

        <p class="text-grey-darker text-md text-center md:mt-0">
            {{ date('F j, Y', $page->date) }}
        </p>

        @include('_partials.post-hero-image')

        <div class="post border-b border-gray-500 sm:text-2xl font-light text-grey-darkest mb-10 pb-4 mt-8 sm:mt-4" v-pre>
            @yield('content')

            @if ($page->categories)
                @foreach ($page->categories as $i => $category)
                    <a
                            href="{{ '/blog/categories/' . $category }}"
                            title="View posts in {{ $category }}"
                            class="category--tag px-2 border border-dashed border-teal-700 hover:border-teal-100 bg-teal-100 hover:bg-teal-400 text-teal-700 hover:text-teal-100 font-semibold rounded px-1"
                            style="background-image: none;"
                    >{{ $category }}</a>
                @endforeach
            @endif

            @include('_partials.author')

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
    </section>
@endsection
