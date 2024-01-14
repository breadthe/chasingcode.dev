<footer class="flex flex-col gap-4 max-w-2xl mx-8 sm:mx-auto {{ $page->belongsTo('/blog') || $page->belongsTo('/contact') ? 'mt-8' : '' }} mb-8 text-center">
    <div class="flex">
        <a href="/blog/feed.atom" class="group w-full flex items-center justify-center gap-2">
            <span class="p-1 rounded bg-black group-hover:bg-teal-400">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12.75 19.5v-.75a7.5 7.5 0 0 0-7.5-7.5H4.5m0-6.75h.75c7.87 0 14.25 6.38 14.25 14.25v.75M6 18.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                </svg>
            </span>
            <span>RSS feed</span>
        </a>
    </div>
    <small class="italic opacity-60">
        2018-{{ date('Y') }} 🦄&nbsp; All content & opinions my own
    </small>
</footer>
