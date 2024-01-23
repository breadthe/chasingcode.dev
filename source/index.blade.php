@extends('_layouts.master')

@push('meta')
    <meta property="og:title" content="{{ $page->title ?  $page->title . ' | ' : '' }}{{ $page->siteName }}"/>
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ $page->getUrl() }}"/>
    <meta property="og:description" content="{{ $page->description ?? $page->siteDescription }}" />
@endpush

@section('body')
    <section class="flex flex-col gap-8 bg-white p-8 mb-8">
        <!-- Intro -->
        <div class="mx-auto max-w-2xl">
            <h2 class="">Hello, I'm Constantin.</h2>

            <h1 class="m-0 text-4xl font-bold text-teal-400">I build for the web.</h1>

            <p class="text-xl font-serif text-left sm:text-justify font-light leading-relaxed">
                I am a full-stack <strong>PHP</strong> developer. From a very early age I've been fascinated with computers, which led me to pursue a degree in <strong>Computer Science</strong>. Later, I fell in love with <strong>web development</strong> and never looked back.
            </p>

            <p class="text-xl font-serif text-left sm:text-justify font-light leading-relaxed">
                Currently I work full time remote as a <strong>Laravel</strong> developer, helping a <strong>SaaS</strong> start-up to grow.
            </p>

            <p class="text-xl font-serif text-left sm:text-justify font-light leading-relaxed">
                I like to <span class="text-2xl">⌨️</span> code, <span class="text-2xl">🛠</span> make software, <span class="text-2xl">🚲</span> ride bicycles, <span class="text-2xl">🏃</span> run, <span class="text-2xl">🏊</span> swim, <span class="text-2xl">⛷</span> ski, <span class="text-2xl">📖</span> read books, <span class="text-2xl">🕹</span> play games.
            </p>
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
                        'bg-gray-100',
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

                        <a href="{{ $featuredPost->getUrl() }}" title="Read - {{ $featuredPost->title }}" class="inline-block text-sm tracking-wide hover:no-underline opacity-60 hover:opacity-100 text-right font-semibold mt-2">
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
                <x-posts-recent :posts="$recentlyUpdatedPosts">Recently updated</x-posts-recent>
            @endif
        </div>
        <!-- END Recent posts -->

        <!-- Tag cloud -->
        <div>
            <h2 class="mb-2">Tag cloud</h2>
            <x-tag-cloud :categories="$categories" :posts="$posts" />
        </div>
        <!-- END Tag cloud -->

    </section>
@endsection