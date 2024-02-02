@extends('_layouts.master')

@push('meta')
    <meta property="og:title" content="{{ $page->title }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ $page->getUrl() }}"/>
    <meta property="og:description" content="{{ $page->description }}" />
@endpush

@section('hero')
    <x-hero title="{{ '#' . $page->title }}" :description="$page->description" />
@endsection

@section('body')
    <section class="p-4 bg-white rounded">
        <div class="border-b border-gray-500 mb-4 pb-4">
            <a href="/blog" title="Back to Blog index" class="text-sm">
                &LeftArrow; Back to Blog
            </a>
        </div>

        @forelse ($page->posts($posts) as $post)
            <x-post-preview-inline :post="$post" />

            @if (! $loop->last)
                <hr class="border-0 border-t my-2 opacity-60">
            @endif
        @empty
            <p>No posts for this tag.</p>
        @endforelse

    {{--    @include('_components.newsletter-signup')--}}
    </section>
@stop
