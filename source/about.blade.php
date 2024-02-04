---
title: About me
---
@extends('_layouts.master')

@push('meta')
    <meta property="og:title" content="About me | {{ $page->siteName }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ $page->getUrl() }}"/>
    <meta property="og:description" content="About the webmaster" />
@endpush

@section('hero')
    <x-hero title="About me" description="Who am I, what makes me tick, what makes me get up in the morning?" />
@endsection

@section('body')
    @include('_nav.about-nav')

    @include('_partials.about.me')
@stop
