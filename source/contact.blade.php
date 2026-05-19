---
title: Contact
---
@extends('_layouts.master')

@push('meta')
    <meta property="og:title" content="Contact | {{ $page->siteName }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ $page->getUrl() }}"/>
    <meta property="og:description" content="Get in touch with {{ $page->siteName }}" />
@endpush

@section('hero')
    <x-hero title="Contact Me" description="Get in touch" />
@endsection

@section('body')

<section class="flex flex-col p-4 sm:p-6 bg-white rounded">
    <p>I'll get back to you when I get to it.</p>

    <form
        name="contact"
        method="post"
        data-netlify="true"
        class="w-full flex flex-col items-end gap-4 mt-4 mx-auto max-w-md p-4 bg-gray-100 border border-gray-200 rounded"
    >
        <div class="w-full">
            <input class="w-full rounded p-2 bg-white inset-shadow-sm border border-gray-200" placeholder="Your Name" type="text" id="name" name="name" />
        </div>

        <div class="w-full">
            <input class="w-full rounded p-2 bg-white inset-shadow-sm border border-gray-200" placeholder="Your Email" type="email" id="email" name="email" />
        </div>

        <div class="w-full">
            <textarea class="w-full rounded p-2 bg-white inset-shadow-sm border border-gray-200" placeholder="Message" id="message" name="message"></textarea>
        </div>

        <button
            type="submit"
            class="bg-teal-700 text-white px-4 py-2 rounded"
        >Send</button>
    </form>
</section>

@stop
