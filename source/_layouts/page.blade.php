@extends('_layouts.master')

@push('meta')
    <meta property="og:title" content="{{ $page->siteName }} Uses" />
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
    <div class="post sm:text-2xl font-light text-grey-darkest">
        @yield('content')
    </div>
</section>

@stop
