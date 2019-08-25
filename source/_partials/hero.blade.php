<section class="hero bg-gray-100 flex items-center flex-col py-8 sm:py-16 px-6 sm:px-0">
        <h1 class="text-3xl sm:text-5xl font-light uppercase flex items-center m-0">
            @if ($page->belongsTo('/blog'))
                <a href="/blog/feed.atom" class="mr-2">
                    <img src="/assets/images/feed-icon-28x28.png" width="28" height="28" alt="Subscribe to the Atom Feed" title="Subscribe to the Atom Feed">
                </a>
            @endif
            {{ $title }}
        </h1>

        @if($description)
            <div class="text-center max-w-2xl">
                <h2 class="text-2xl sm:text-3xl text-gray-600 leading-normal font-sans font-light m-0 pt-4">
                    {{ $description }}
                </h2>
            </div>
        @endif
</section>
