@extends('_layouts.master')

@push('meta')
    <meta property="og:title" content="Contact {{ $page->siteName }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ $page->getUrl() }}"/>
    <meta property="og:description" content="Get in touch with {{ $page->siteName }}" />
@endpush

@section('hero')
    @include('_partials.hero',[
        'title' => 'Contact Us',
        'description' => '',
    ])
@endsection

@section('body')
<h3>Get In Touch</h3>
<p>We'll get back to you ASAP as possible!</p>

<section class="container max-w-xl">
    <form
        name="contact"
        method="post"
        data-netlify="true"
    >
        <div
            class="flex justify-start pb-4"
        >
            <div class="w-full">
                <input placeholder="Your Name" type="text" id="name" name="name" />
            </div>
        </div>
        <div
            class="flex justify-start pb-4"
        >
            <div class="w-full">
                <input placeholder="Your Email" type="email" id="email" name="email" />
            </div>
        </div>
        <div
            class="flex justify-start pb-4"
        >
            <div class="w-full">
                <textarea placeholder="Message" id="message" name="message"></textarea>
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
