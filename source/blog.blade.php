---
pagination:
    collection: posts
    perPage: 5
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
    <hr class="border-0 border-t border-teal-700 my-6">

    @foreach ($pagination->items as $post)
        @include('_components.post-preview-inline')

        @if ($post != $pagination->items->last())
            <hr class="border-0 border-t border-teal-700 my-6">
        @endif
    @endforeach

    @if ($pagination->pages->count() > 1)
        <nav class="flex text-base my-8">
            @if ($previous = $pagination->previous)
                <a
                    href="{{ $previous }}"
                    title="Previous Page"
                    class="bg-gray-200 hover:bg-gray-400 rounded mr-3 px-5 py-3 leading-loose"
                >&LeftArrow;</a>
            @endif

            @foreach ($pagination->pages as $pageNumber => $path)
                @if($pagination->currentPage == $pageNumber)
                        <span
                                title="Page {{ $pageNumber }}"
                                class="bg-gray-200 rounded mr-3 px-5 py-3 leading-loose"
                        >{{ $pageNumber }}</span>
                @else
                        <a
                                href="{{ $path }}"
                                title="Go to Page {{ $pageNumber }}"
                                class="bg-gray-200 hover:bg-gray-400 rounded mr-3 px-5 py-3 leading-loose"
                        >{{ $pageNumber }}</a>
                @endif
            @endforeach

            @if ($next = $pagination->next)
                <a
                    href="{{ $next }}"
                    title="Next Page"
                    class="bg-gray-200 hover:bg-gray-400 rounded mr-3 px-5 py-3 leading-loose"
                >&RightArrow;</a>
            @endif
        </nav>
    @endif
@stop
