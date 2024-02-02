---
pagination:
    collection: posts
    perPage: 10
---
@extends('_layouts.master')

@push('meta')
    <meta property="og:title" content="{{ $page->siteName }} Blog" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ $page->getUrl() }}"/>
    <meta property="og:description" content="The list of blog posts for {{ $page->siteName }}" />
@endpush

@section('hero')
    <x-hero title="Blog index" description="Pontificating on Laravel • Livewire • Alpine.js • Svelte • Vue.js • Tauri • Electron • TailwindCSS • and more..." />
@endsection

@section('body')
    <section class="p-4 sm:p-6 bg-white rounded">
        @foreach ($pagination->items as $post)
            <x-post-preview-inline :post="$post" />

            <hr class="border-0 border-t my-2 opacity-60">
        @endforeach

        <x-blog-pagination :pagination="$pagination" />
    </section>
@stop
