@extends('_layouts.master')

@push('meta')
    <meta property="og:title" content="{{ $page->title }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ $page->getUrl() }}"/>
    <meta property="og:description" content="{{ $page->description }}" />
@endpush

@section('hero')
    @include('_partials.hero',[
        'title' => $page->title,
        'description' => $page->description,
    ])
@endsection

@section('body')
    <div class="text-2xl border-b border-pink mb-6 pb-10">
        <a href="/blog" title="Back to Blog index">
            &LeftArrow; Back to Blog
        </a>
    </div>

    @foreach ($page->posts($posts) as $post)
            @include('_components.post-preview-inline')

        @if (! $loop->last)
            <hr class="w-full border-b mt-2 mb-6">
        @endif
    @endforeach

{{--    @include('_components.newsletter-signup')--}}
@stop
