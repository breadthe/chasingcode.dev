---
pagination:
    collection: posts
    perPage: 4
---
@extends('_layouts.master')

@push('meta')
    <meta property="og:title" content="{{ $page->siteName }} Blog" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ $page->getUrl() }}"/>
    <meta property="og:description" content="The list of blog posts for {{ $page->siteName }}" />
@endpush

@section('hero')
    @include('_partials.hero',[
        'title' => 'Blog',
        'description' => 'Pontificating on all things Laravel // Vue.js // TailwindCSS // and more...',
    ])
@endsection

@section('body')
    <hr class="border-b my-6">

    @foreach ($pagination->items as $post)
        @include('_components.post-preview-inline')

        @if ($post != $pagination->items->last())
            <hr class="border-b my-6">
        @endif
    @endforeach

    @if ($pagination->pages->count() > 1)
        <nav class="flex text-base my-8">
            @if ($previous = $pagination->previous)
                <a
                    href="{{ $previous }}"
                    title="Previous Page"
                    class="bg-grey-lighter hover:bg-grey-light rounded mr-3 px-5 py-3"
                >&LeftArrow;</a>
            @endif

            @foreach ($pagination->pages as $pageNumber => $path)
                @if($pagination->currentPage == $pageNumber)
                        <span
                                title="Page {{ $pageNumber }}"
                                class="bg-grey-lighter rounded mr-3 px-5 py-3 text-grey-dark"
                        >{{ $pageNumber }}</span>
                @else
                        <a
                                href="{{ $path }}"
                                title="Go to Page {{ $pageNumber }}"
                                class="bg-grey-lighter hover:bg-grey-light rounded mr-3 px-5 py-3 text-pink-dark"
                        >{{ $pageNumber }}</a>
                @endif
            @endforeach

            @if ($next = $pagination->next)
                <a
                    href="{{ $next }}"
                    title="Next Page"
                    class="bg-grey-lighter hover:bg-grey-light rounded mr-3 px-5 py-3"
                >&RightArrow;</a>
            @endif
        </nav>
    @endif
@stop
