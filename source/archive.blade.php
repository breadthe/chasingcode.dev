@extends('_layouts.master')

@push('meta')
    <meta property="og:title" content="{{ $page->siteName }} Blog" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ $page->getUrl() }}"/>
    <meta property="og:description" content="The list of blog posts for {{ $page->siteName }}" />
@endpush

@section('hero')
    @include('_partials.hero',[
        'title' => 'Blog Archive',
        'description' => "An yearly archive of all the articles posted on $page->siteName",
    ])
@endsection

@section('body')
    <div class="flex flex-col-reverse sm:flex-row">
        <section class="w-full bg-white p-4 sm:p-6 sm:mr-8 shadow-xl">
            @foreach ($posts->groupBy(function ($post) { return $post->getDate()->format('Y'); }) as $year => $yearPosts)
                <div class="mb-8">
                    <h2 class="flex items-center justify-between text-teal-700">
                        {{ $year }}
                        <small class="text-base text-gray-700 font-light">[{{ $yearPosts->count() }}]</small>
                    </h2>

                    @foreach ($yearPosts as $post)
                        <div class="mb-4 flex sm:flex-row flex-col justify-between">
                            <a
                                    href="{{ $post->getUrl() }}"
                                    class="font-semibold text-black border-b border-solid border-teal-400 hover:bg-teal-100 hover:border-b hover:border-solid hover:border-black"
                            >{{ $post->title }}</a>

                            <span class="text-base font-light text-right">
                                {{ $post->getDate()->format('M d') }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </section>

        @include('_partials.tag-cloud')
    </div>
@stop
