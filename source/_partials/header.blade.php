<header class="flex items-center py-4" role="banner">
    <div class="container flex items-center max-w-6xl mx-auto px-4 lg:px-8">
        <div class="flex items-center">
            <a href="/" title="{{ $page->siteName }} home" class="flex items-center justify-center gap-2 mr-2">
                <img width="48" height="48" src="/assets/images/chasingcode-logo.png" alt="{{ $page->siteName }} logo" />

                <span class="text-2xl leading-none font-serif font-bold text-teal-400">{{ $page->siteName }}</span>
            </a>
        </div>

        <div id="vue-search" class="flex flex-1 justify-end items-center sm:gap-4">
            @if($page->belongsTo('/blog'))
                <search
                    data-belongs-to-blog="{{ $page->belongsTo('/blog') }}"
                ></search>
            @endif

            @include('_nav.menu')

            @include('_nav.menu-toggle')
        </div>
    </div>
</header>

@include('_nav.menu-responsive')
