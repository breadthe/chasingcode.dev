---
title: Archive
---
@extends('_layouts.master')

@push('meta')
    <meta property="og:title" content="Archive | {{ $page->siteName }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ $page->getUrl() }}"/>
    <meta property="og:description" content="{{ $page->siteName }} blog article archive" />
@endpush

@section('hero')
    <x-hero title="Blog Archive" description="A yearly archive of all the blog posts" />
@endsection

@section('body')
    <div class="flex flex-col gap-4">
        <aside class="px-4 mb-4">
            <x-tag-cloud :tags="$tags" :posts="$posts" />
        </aside>

        <section class="p-4 sm:p-6 bg-white rounded">
            @foreach ($posts->groupBy(function ($post) { return $post->getDate()->format('Y'); }) as $year => $yearPosts)
                <div class="mb-8">
                    <h2 class="flex items-baseline gap-2 mb-2 text-teal-700">
                        {{ $year }}
                        <small class="text-xs text-gray-400 font-light">({{ $yearPosts->count() }})</small>
                    </h2>

                    @foreach ($yearPosts as $post)
                        <div class="flex items-baseline mb-2">
                            <span class="w-16 text-xs text-gray-400 font-mono">
                                {{ $post->getDate()->format('M d') }}
                            </span>

                            <a
                                    href="{{ $post->getUrl() }}"
                                    class="flex-1 underline underline-offset-2 decoration-teal-200 hover:decoration-teal-400 decoration-2"
                            >{{ $post->title }}</a>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </section>
    </div>
@stop
