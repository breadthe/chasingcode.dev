@extends('_layouts.master')

@push('meta')
    <meta property="og:title" content="About me | {{ $page->siteName }} Blog" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ $page->getUrl() }}"/>
    <meta property="og:description" content="About the webmaster" />
@endpush

@section('hero')
    <x-hero title="About the site" description="The tech stack behind the site." />
@endsection

@section('body')
    @include('_nav.about-nav')

    <section class="flex flex-col gap-8">
        @include('_partials.about.site')
    </section>
@stop
