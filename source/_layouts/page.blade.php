@extends('_layouts.master')

@push('meta')
    <meta property="og:title" content="{{ $page->siteName }} Uses" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ $page->getUrl() }}"/>
    <meta property="og:description" content="{{ $page->description }}" />
@endpush

@section('hero')
    <x-hero :title="$page->title" :description="$page->description" />
@endsection

@section('body')

<section class="p-4 sm:p-6 bg-white rounded">
    <div class="post font-light text-grey-darkest">
        @yield('content')
    </div>
</section>

@stop
