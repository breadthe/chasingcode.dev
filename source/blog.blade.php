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
        'description' => 'Pontificating on Laravel // Livewire // Alpine.js // Svelte // Vue.js // Tauri // Electron // TailwindCSS // and more...',
    ])
@endsection

@section('body')
    <section class="p-4 sm:p-6 shadow-xl">
        @foreach ($pagination->items as $post)
            @include('_components.post-preview-inline')

            @if ($post != $pagination->items->last())
                <hr class="border-0 border-t my-6">
            @endif
        @endforeach

        @if ($pagination->pages->count() > 1)
            <nav class="flex flex-wrap text-base">
                @if ($previous = $pagination->previous)
                    <a
                        href="{{ $previous }}"
                        title="Previous Page"
                        class="hover:bg-teal-400 text-teal-400 hover:text-teal-100 font-semibold rounded mr-3 px-5 py-3 leading-loose"
                    >&LeftArrow;</a>
                @endif

                @foreach ($pagination->pages as $pageNumber => $path)
                    @if($pagination->currentPage == $pageNumber)
                            <span
                                    title="Page {{ $pageNumber }}"
                                    class="text-teal-700 font-semibold rounded mr-3 px-5 py-3 leading-loose"
                                    style="background-image: linear-gradient(to bottom, transparent 70%, #4FD1C5 70%);"
                            >{{ $pageNumber }}</span>
                    @else
                            <a
                                    href="{{ $path }}"
                                    title="Go to Page {{ $pageNumber }}"
                                    class="hover:bg-teal-400 text-teal-400 hover:text-teal-100 font-semibold rounded mr-3 px-5 py-3 leading-loose"
                            >{{ $pageNumber }}</a>
                    @endif
                @endforeach

                @if ($next = $pagination->next)
                    <a
                        href="{{ $next }}"
                        title="Next Page"
                        class="hover:bg-teal-400 text-teal-400 hover:text-teal-100 font-semibold rounded mr-3 px-5 py-3 leading-loose"
                    >&RightArrow;</a>
                @endif
            </nav>
        @endif
    </section>
@stop
