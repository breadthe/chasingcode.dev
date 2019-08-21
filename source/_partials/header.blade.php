<header class="flex items-center bg-gray-800 py-4 {{ $page->belongsTo('/blog') ? '' : '' }}" role="banner">
    <div class="container flex items-center max-w-6xl mx-auto px-4 lg:px-8">
        <div class="flex items-center">
            <a href="/" title="{{ $page->siteName }} home" class="flex items-center justify-center rounded-full w-12 h-12 mr-2">
                <img class="h-12 mr-3" src="/assets/images/chasingcode-logo.png" alt="{{ $page->siteName }} logo" />
            </a>

            <h1 class="text-xl sm:text-3xl my-0">
                <a href="/" title="{{ $page->siteName }} home" class="font-light font-sans text-teal-400 sm:text-teal-200 hover:text-teal-400">
                    {{ $page->siteName }}
                </a>
            </h1>
        </div>

        <div id="vue-search" class="flex flex-1 justify-end items-center">
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
