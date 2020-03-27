<footer class="max-w-2xl mx-8 sm:mx-auto {{ $page->belongsTo('/blog') || $page->belongsTo('/contact') ? 'mt-8' : '' }} mb-8 text-base text-gray-700 italic font-light text-center">
    {{ date('Y') }} 🦄 All content & opinions my own
</footer>
