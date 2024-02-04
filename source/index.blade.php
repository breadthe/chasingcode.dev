@extends('_layouts.master')

@push('meta')
    <meta property="og:title" content="{{ $page->title ?  $page->title . ' | ' : '' }}{{ $page->siteName }}"/>
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ $page->getUrl() }}"/>
    <meta property="og:description" content="{{ $page->description ?? $page->siteDescription }}" />
@endpush

@section('body')
    <section class="flex flex-col gap-8 p-8 bg-white rounded">
        <!-- Intro -->
        <div class="mx-auto max-w-6xl text-center">
            <h1 class="m-0 text-4xl text-teal-400">I build for the web</h1>

            <h2 class="m-0 text-gray-700 font-light">and sometimes I <a href="/blog" class="underline underline-offset-2 decoration-4 decoration-teal-200 hover:decoration-teal-400 hover:text-black">blog</a> about it.</h2>

            <p>These days I'm really into <a href="/blog/tags/laravel">Laravel</a> with <a href="/blog/tags/livewire">Livewire</a>, <a href="/blog/tags/tailwind">Tailwind</a>, <a href="/blog/tags/svelte">Svelte</a>, and <a href="/blog/tags/tauri">Tauri</a>.</p>

            <!--<p>
                <a href="/about" class="border-b border-solid border-teal-400">More about me <span class="font-sans">&RightArrow;</span></a>
            </p>-->
        </div>
        <!-- END Intro -->

        <!-- Featured posts -->
        <div>
            <h2 class="mb-2">Featured posts</h2>

            <div class="grid sm:grid-rows-2 sm:grid-cols-2 gap-8">
                @foreach ($posts->where('featured', true)->sortByDesc('date')->take(4) as $featuredPost)
                    <div @class([
                        // 'row-span-2' => $loop->first,
                        'flex',
                        'flex-col',
                        'justify-between',
                        'bg-gray-50',
                        'rounded',
                        'p-4',
                    ])>
                        <div>
                            {{--@if ($featuredPost->image)
                                <img src="{{ $featuredPost->image }}" alt="{{ $featuredPost->title }} cover image" class="mb-6">
                            @endif--}}

                            <small class="opacity-60">
                                {{ $featuredPost->getDate()->format('F j, Y') }}
                            </small>

                            <h3 class="text-xl font-semibold font-serif leading-snug mt-0">
                                <a href="{{ $featuredPost->getUrl() }}" title="Read {{ $featuredPost->title }}" class="text-teal-700 hover:text-teal-900">
                                    {{ $featuredPost->title }}
                                </a>
                            </h3>

                            <p class="mt-2">{!! $featuredPost->getExcerpt() !!}</p>
                        </div>

                        <a href="{{ $featuredPost->getUrl() }}" title="Read - {{ $featuredPost->title }}" class="inline-block text-sm tracking-wide no-underline opacity-60 hover:opacity-100 text-right font-semibold mt-2">
                            Read more &RightArrow;
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        <!-- END Featured posts -->

        <!-- Recent posts -->
        <div class="flex flex-col sm:flex-row gap-8">
            <x-posts-recent :posts="$posts->sortByDesc('date')->take(5)" seeAll>Recent posts</x-posts-recent>

            @if(($recentlyUpdatedPosts = $posts->whereNotNull('updated')->sortByDesc('updated')->take(5)) && count($recentlyUpdatedPosts) > 0)
                <x-posts-recent :posts="$recentlyUpdatedPosts" displayUpdatedDate>Recently updated</x-posts-recent>
            @endif
        </div>
        <!-- END Recent posts -->

        <!-- Tag cloud -->
        <div>
            <h2 class="mb-2">Tag cloud</h2>
            <x-tag-cloud :tags="$tags" :posts="$posts" />
        </div>
        <!-- END Tag cloud -->

    </section>
@endsection