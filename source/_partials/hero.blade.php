<section class="hero h-auto flex items-center flex-col {{ $page->belongsTo('/blog') ? 'pt-0 sm:pt-8' : 'hero-red py-6 sm:py-12' }}">
        <div class="text-center mb-2 flex items-center">
            @if ($page->belongsTo('/blog'))
                <a href="/blog/feed.atom" class="mt-5 mr-2">
                    <img src="/assets/images/feed-icon-28x28.png" width="28" height="28" alt="Subscribe to the Atom Feed" title="Subscribe to the Atom Feed">
                </a>
            @endif
            <h1 class="text-3xl sm:text-5xl font-light uppercase {{ $page->belongsTo('/blog') ? 'text-grey-darkest' : 'text-white' }}">
                {{ $title }}
            </h1>
        </div>

        <div class="text-center px-6 sm:px-0 max-w-md">
            <h2 class="text-2xl sm:text-3xl leading-normal font-light text-shadow {{ $page->belongsTo('/blog') ? 'text-grey-dark' : 'text-grey-lightest' }}">
                {{ $description }}
            </h2>
        </div>
</section>
