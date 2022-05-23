@extends('_layouts.master')

@push('meta')
    <meta property="og:title" content="{{ $page->title ?  $page->title . ' | ' : '' }}{{ $page->siteName }}"/>
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ $page->getUrl() }}"/>
    <meta property="og:description" content="{{ $page->description ?? $page->siteDescription }}" />
@endpush

@section('hero')
    @include('_partials.hero-welcome')
    @include('_partials.closed-source')
    @include('_partials.open-source')
    @include('_partials.packages')
@endsection
