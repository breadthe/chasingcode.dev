@extends('_layouts.master')

@push('meta')
    <meta property="og:title" content="Contact {{ $page->siteName }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ $page->getUrl() }}"/>
    <meta property="og:description" content="Get in touch with {{ $page->siteName }}" />
@endpush

@section('hero')
    @include('_partials.hero',[
        'title' => 'Contact Me',
        'description' => '',
    ])
@endsection

@section('body')

<section class="p-6 shadow-xl">
    <h3>Get In Touch</h3>
    <p>I'll get back to you ASAP as possible!</p>

    <form
        name="contact"
        method="post"
        data-netlify="true"
        class="bg-gray-200 border shadow"
    >
        <div
            class="flex justify-start pb-4"
        >
            <div class="w-full">
                <input class="shadow-inner border" placeholder="Your Name" type="text" id="name" name="name" />
            </div>
        </div>
        <div
            class="flex justify-start pb-4"
        >
            <div class="w-full">
                <input class="shadow-inner border" placeholder="Your Email" type="email" id="email" name="email" />
            </div>
        </div>
        <div
            class="flex justify-start pb-4"
        >
            <div class="w-full">
                <textarea class="shadow-inner border" placeholder="Message" id="message" name="message"></textarea>
            </div>
        </div>
        <div class="text-right">
            <button
                type="submit"
                class=""
            >Send</button>
        </div>
    </form>
</section>

@stop
