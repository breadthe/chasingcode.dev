<section class="hero h-auto flex items-center flex-col mt-8 {{ $page->belongsTo('/blog') ? 'mb-4' : '' }}">
        <h1 class="text-3xl sm:text-5xl font-light uppercase flex items-center">
            @if ($page->belongsTo('/blog'))
                <a href="/blog/feed.atom" class="mr-2">
                    <img src="/assets/images/feed-icon-28x28.png" width="28" height="28" alt="Subscribe to the Atom Feed" title="Subscribe to the Atom Feed">
                </a>
            @endif
            {{ $title }}
        </h1>

        <div class="text-center px-6 sm:px-0 max-w-2xl">
            <h2 class="text-2xl sm:text-3xl text-gray-600 leading-normal font-sans font-light">
                {{ $description }}
            </h2>
        </div>
</section>
