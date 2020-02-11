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
    <section class="p-4 sm:p-6 shadow-xl">
        <div class="text-2xl border-b border-gray-500 mb-6 pb-6">
            <a href="/blog" title="Back to Blog index">
                &LeftArrow; Back to Blog
            </a>
        </div>

        @foreach ($page->posts($posts) as $post)
                @include('_components.post-preview-inline')

            @if (! $loop->last)
                <hr class="border-0 border-t my-6">
            @endif
        @endforeach

    {{--    @include('_components.newsletter-signup')--}}
    </section>
@stop
