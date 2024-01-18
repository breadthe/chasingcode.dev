@extends('_layouts.master')

@push('meta')
    <meta property="og:title" content="{{ $page->siteName }} Blog" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ $page->getUrl() }}"/>
    <meta property="og:description" content="{{ $page->siteName }} blog article archive" />
@endpush

@section('hero')
    <x-hero title="Blog Archive" description="{{'A yearly archive of all the articles posted on ' . $page->siteName}}" />
@endsection

@section('body')
    <div class="grid grid-cols-1 sm:grid-cols-12 sm:gap-8">
        <section class="sm:col-span-10 order-last sm:order-first w-full p-4 sm:p-6 bg-white rounded">
            @foreach ($posts->groupBy(function ($post) { return $post->getDate()->format('Y'); }) as $year => $yearPosts)
                <div class="mb-8">
                    <h2 class="flex items-center justify-between text-teal-700">
                        {{ $year }}
                        <small class="text-base text-gray-700 font-light">[{{ $yearPosts->count() }}]</small>
                    </h2>

                    @foreach ($yearPosts as $post)
                        <div class="mb-4 flex sm:flex-row flex-col justify-between">
                            <a
                                    href="{{ $post->getUrl() }}"
                                    class="font-semibold text-black border-b border-solid border-teal-400 hover:bg-teal-100 hover:border-b hover:border-solid hover:border-black"
                            >{{ $post->title }}</a>

                            <span class="text-base font-light text-right">
                                {{ $post->getDate()->format('M d') }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </section>

        <div class="sm:col-span-2 order-first sm:order-last">
            <x-tag-cloud :categories="$categories" :posts="$posts" />
        </div>
    </div>
@stop
