<footer class="max-w-2xl mx-8 sm:mx-auto {{ $page->belongsTo('/blog') || $page->belongsTo('/contact') ? 'mt-8' : '' }} mb-8 text-gray-500 italic font-light text-center">
    {{ date('Y') }} 🦄 All content is my own and does not reflect my employer's or anyone else's opinions.
</footer>
