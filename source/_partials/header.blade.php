<header class="flex items-center h-20 sm:h-24 py-4 {{ $page->belongsTo('/blog') ? '' : '' }}" role="banner">
    <div class="container flex items-center max-w-4xl mx-auto px-4 lg:px-8">
        <div class="flex items-center">
            <a href="/" title="{{ $page->siteName }} home" class="inline-flex items-center">
                <img class="h-12 mr-3" src="/assets/images/chasingcode-logo.png" alt="{{ $page->siteName }} logo" />

                <h1 class="no-underline font-normal text-teal-700 text-2xl sm:text-3xl my-0 text-gray-600">
                    {{ $page->siteName }}
                </h1>
            </a>
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
